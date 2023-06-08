import json
import uuid

import requests
from django.contrib import messages
from django.contrib.contenttypes.models import ContentType
from django.db import IntegrityError
from django.shortcuts import render, redirect
from django.utils import timezone

from extras.forms import PublicWebhookForm
from extras.models import Webhook
from extras.tables import PublicWebhookTable
from statuspage.config import get_config
from statuspage.views import BaseView
from subscribers.forms import PublicSubscriberForm, PublicSubscriberManagementForm
from subscribers.models import Subscriber


__all__ = (
    'SubscriberSubscribeView',
    'SubscriberVerifyView',
    'SubscriberManageView',
    'SubscriberManageWebhookListView',
    'SubscriberManageWebhookCreateView',
    'SubscriberManageWebhookEditView',
    'SubscriberManageWebhookDeleteView',
    'SubscriberUnsubscribeView',
    'SubscriberRequestManagementKeyView',
)


class SubscriberSubscribeView(BaseView):
    template_name = 'home/subscribers/subscribe.html'

    def get(self, request):
        form = PublicSubscriberForm()

        return render(request, self.template_name, {
            'form': form,
        })

    def post(self, request):
        form = PublicSubscriberForm(data=request.POST)

        if form.is_valid():
            config = get_config()

            provider = config.CAPTCHA_PROVIDER
            secret = config.CAPTCHA_PRIVATE_KEY
            if provider:
                siteverify_url = config.captcha_provider_siteverify()

                formdata = config.captcha_provider_formdata()
                captcha_response = request.POST.get(formdata)

                response = requests.post(siteverify_url, data={
                    'secret': secret,
                    'response': captcha_response,
                })
                outcome = response.json()
                if not outcome['success']:
                    messages.error(request, 'Captcha Verification Failed')
                    return redirect('subscriber_subscribe')

            email = form.cleaned_data.get('email')
            try:
                subscriber = Subscriber()
                subscriber.email = email
                subscriber.save()
            except IntegrityError:
                pass
            messages.success(request, 'Successfully subscribed to Updates. Please check your Mails for verification.')

        return render(request, self.template_name, {
            'form': form,
        })


class SubscriberRequestManagementKeyView(BaseView):
    template_name = 'home/subscribers/request-management-key.html'

    def get(self, request):
        form = PublicSubscriberForm()

        return render(request, self.template_name, {
            'form': form,
        })

    def post(self, request):
        form = PublicSubscriberForm(data=request.POST)

        if form.is_valid():
            config = get_config()

            provider = config.CAPTCHA_PROVIDER
            secret = config.CAPTCHA_PRIVATE_KEY
            if provider:
                siteverify_url = config.captcha_provider_siteverify()

                formdata = config.captcha_provider_formdata()
                captcha_response = request.POST.get(formdata)

                response = requests.post(siteverify_url, data={
                    'secret': secret,
                    'response': captcha_response,
                })
                outcome = response.json()
                if not outcome['success']:
                    messages.error(request, 'Captcha Verification Failed')
                    return redirect('subscriber_subscribe')

            email = form.cleaned_data.get('email')
            try:
                subscriber = Subscriber.objects.get(email=email)
                subscriber.management_key = uuid.uuid4()
                subscriber.save()
                config = get_config()
                subscriber.send_mail(subject=f'Manage your Subscription at {config.SITE_TITLE}', template='subscribers/management-key')
            except:
                pass
            messages.success(request, 'Successfully requested the E-Mail.')

        return render(request, self.template_name, {
            'form': form,
        })


class SubscriberVerifyView(BaseView):
    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is already verified.')
            return redirect('subscriber_manage', **kwargs)

        subscriber.email_verified_at = timezone.now()
        subscriber.save()
        messages.success(request, 'This E-Mail has been verified.')
        return redirect('subscriber_manage', **kwargs)


class SubscriberManageView(BaseView):
    template_name = 'home/subscribers/manage.html'

    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        form = PublicSubscriberManagementForm(instance=subscriber)

        webhook_form = PublicWebhookForm()
        table = PublicWebhookTable(
            data=subscriber.webhooks.all(),
        )

        return render(request, self.template_name, {
            'form': form,
            'subscriber': subscriber,
            'webhook_form': webhook_form,
            'table': table,
        })

    def post(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        form = PublicSubscriberManagementForm(instance=subscriber, data=request.POST)

        if form.is_valid():
            messages.success(request, 'Successfully updated the Subscription preferences')
            form.save()

        return redirect('subscriber_manage', **kwargs)


class SubscriberManageWebhookListView(BaseView):
    template_name = 'home/subscribers/manage/webhook_list.html'

    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        table = PublicWebhookTable(
            data=subscriber.webhooks.all(),
        )

        return render(request, self.template_name, {
            'subscriber': subscriber,
            'table': table,
        })

    def post(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(kwargs.get('management_key'))
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        return redirect('subscriber_manage_webhook_list', **kwargs)


class SubscriberManageWebhookCreateView(BaseView):
    template_name = 'home/subscribers/manage/webhook_create.html'

    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        table = PublicWebhookTable(
            data=subscriber.webhooks.all(),
        )
        form = PublicWebhookForm()

        return render(request, self.template_name, {
            'subscriber': subscriber,
            'table': table,
            'form': form,
        })

    def post(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(kwargs.get('management_key'))
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        form = PublicWebhookForm(data=request.POST)
        if form.is_valid():
            webhook = form.save(commit=False)
            webhook.subscriber = subscriber
            webhook.conditions = {
                'and': [
                    {
                        'attr': 'visibility',
                        'value': 'true',
                    }
                ],
            }
            webhook.save()
            webhook.content_types.set(
                map(lambda x: ContentType.objects.get(app_label=x.split(':')[0], model=x.split(':')[1]),
                    ['components:component', 'incidents:incident', 'incidents:incidentupdate',
                     'maintenances:maintenance', 'maintenances:maintenanceupdate']))

            messages.success(request, 'Successfully created the Webhook')
        else:
            print(form.errors)
            messages.error(request, 'An error occured.')
            return render(request, self.template_name, {
                'subscriber': subscriber,
                'form': form,
            })

        return redirect('subscriber_manage_webhook_list', **kwargs)


class SubscriberManageWebhookEditView(BaseView):
    template_name = 'home/subscribers/manage/webhook_edit.html'

    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(kwargs.get('management_key'))
        webhook = Webhook.objects.get(pk=kwargs.get('webhook'))
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        if webhook.subscriber.id is not subscriber.id:
            messages.error(request, 'This Webhook has not been found.')
            return redirect('home')

        form = PublicWebhookForm(instance=webhook)

        return render(request, self.template_name, {
            'subscriber': subscriber,
            'webhook': webhook,
            'form': form,
        })

    def post(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(kwargs.get('management_key'))
        webhook = Webhook.objects.get(pk=kwargs.get('webhook'))
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        if webhook.subscriber.id is not subscriber.id:
            messages.error(request, 'This Webhook has not been found.')
            return redirect('home')

        form = PublicWebhookForm(instance=webhook, data=request.POST)
        if form.is_valid():
            form_webhook = form.save(commit=False)
            form_webhook.save()
            form_webhook.content_types.set(
                map(lambda x: ContentType.objects.get(app_label=x.split(':')[0], model=x.split(':')[1]),
                    ['components:component', 'incidents:incident', 'incidents:incidentupdate',
                        'maintenances:maintenance', 'maintenances:maintenanceupdate']))
        else:
            print(form.errors)
            messages.error(request, 'An error occured.')
            return render(request, self.template_name, {
                'subscriber': subscriber,
                'form': form,
            })

        return redirect('subscriber_manage_webhook_list', management_key=kwargs.get('management_key'))


class SubscriberManageWebhookDeleteView(BaseView):
    template_name = 'home/subscribers/manage/webhook_delete.html'

    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(kwargs.get('management_key'))
        webhook = Webhook.objects.get(pk=kwargs.get('webhook'))
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        if webhook.subscriber.id is not subscriber.id:
            messages.error(request, 'This Webhook has not been found.')
            return redirect('home')

        return render(request, self.template_name, {
            'subscriber': subscriber,
            'webhook': webhook,
        })

    def post(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(kwargs.get('management_key'))
        webhook = Webhook.objects.get(pk=kwargs.get('webhook'))
        if not get_config().SITE_PUBLIC_WEBHOOKS:
            messages.error(request, 'This feature is not enabled.')
            return redirect('subscriber_manage', **kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        if webhook.subscriber.id is not subscriber.id:
            messages.error(request, 'This Webhook has not been found.')
            return redirect('home')

        webhook.delete()
        messages.success(request, 'Successfully deleted the Webhook')

        return redirect('subscriber_manage_webhook_list', management_key=kwargs.get('management_key'))


class SubscriberUnsubscribeView(BaseView):
    template_name = 'home/subscribers/unsubscribe.html'

    def get(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        return render(request, self.template_name, {
            'subscriber': subscriber,
        })

    def post(self, request, **kwargs):
        subscriber = Subscriber.get_by_management_key(**kwargs)

        if not subscriber:
            messages.error(request, 'This Subscriber has not been found.')
            return redirect('home')

        if not subscriber.email_verified_at:
            messages.error(request, 'This E-Mail is not verified.')
            return redirect('home')

        subscriber.delete()
        messages.success(request, 'Successfully unsubscribed.')
        return redirect('home')
