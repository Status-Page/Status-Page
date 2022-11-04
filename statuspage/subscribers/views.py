from django.contrib import messages
from django.shortcuts import redirect

from statuspage.config import get_config
from statuspage.views import generic
from .models import Subscriber
from . import tables
from . import forms
from . import filtersets


class SubscriberListView(generic.ObjectListView):
    queryset = Subscriber.objects.all()
    table = tables.SubscriberTable
    filterset = filtersets.SubscriberFilterSet
    filterset_form = forms.SubscriberFilterForm


class SubscriberView(generic.ObjectView):
    queryset = Subscriber.objects.all()

    def get(self, request, **kwargs):
        action = request.GET.get('action')
        subscriber = self.get_object(**kwargs)

        if not action:
            return super().get(request, **kwargs)

        if action == 'resend_verification_mail' and not subscriber.email_verified_at:
            config = get_config()
            subscriber.send_mail(
                subject=f'Verify your Subscription to {config.SITE_TITLE}',
                template='subscribers/verification',
            )
            messages.success(request, 'Successfully resent verification mail.')
            return redirect('subscribers:subscriber', pk=subscriber.pk)

        if action == 'reset_verification' and subscriber.email_verified_at:
            subscriber.email_verified_at = None
            subscriber.save()
            messages.success(request, 'Successfully reset verification state.')
            return redirect('subscribers:subscriber', pk=subscriber.pk)

        messages.error(request, 'Unknown Action')
        return redirect('subscribers:subscriber', pk=subscriber.pk)


class SubscriberEditView(generic.ObjectEditView):
    queryset = Subscriber.objects.all()
    form = forms.SubscriberForm


class SubscriberDeleteView(generic.ObjectDeleteView):
    queryset = Subscriber.objects.all()


class SubscriberBulkDeleteView(generic.BulkDeleteView):
    queryset = Subscriber.objects.all()
    table = tables.SubscriberTable
