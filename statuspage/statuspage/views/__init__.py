import platform
import sys
import uuid
from itertools import chain

from django.conf import settings
from django.contrib import messages
from django.db import IntegrityError
from django.db.models import Q
from django.shortcuts import redirect, render
from django.utils import timezone
from django.views.decorators.csrf import requires_csrf_token
from django.views.defaults import ERROR_500_TEMPLATE_NAME
from django.template import loader
from django.template.exceptions import TemplateDoesNotExist
from django.http import HttpResponseServerError

from components.choices import ComponentStatusChoices
from components.models import ComponentGroup, Component
from incidents.models import Incident
from incidents.choices import IncidentStatusChoices
from maintenances.models import Maintenance
from maintenances.choices import MaintenanceStatusChoices
from metrics.models import Metric
from statuspage.config import get_config
from statuspage.views.generic import BaseView
from subscribers.forms import PublicSubscriberForm, PublicSubscriberManagementForm
from subscribers.models import Subscriber


class HomeView(BaseView):
    template_name = 'home.html'

    def get(self, request):
        component_groups = ComponentGroup.objects.filter(
            visibility=True,
        )
        ungrouped_components = Component.objects.filter(component_group=None)

        open_incidents = Incident.objects.filter(
            ~Q(status=IncidentStatusChoices.RESOLVED),
            visibility=True,
        )
        open_maintenances = Maintenance.objects.filter(
            ~Q(status=MaintenanceStatusChoices.SCHEDULED),
            ~Q(status=MaintenanceStatusChoices.COMPLETED),
            visibility=True,
        )
        open_incidents_maintenances = list(chain(open_incidents, open_maintenances))

        upcoming_maintenances = Maintenance.objects.filter(
            status=MaintenanceStatusChoices.SCHEDULED,
            visibility=True,
        )

        datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
        datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59, hour=23)
        daterange = datenow - timezone.timedelta(days=7)

        resolved_incidents = Incident.objects.filter(
            status=IncidentStatusChoices.RESOLVED,
            visibility=True,
            last_updated__range=(daterange, datenow_end),
        )
        resolved_maintenances = Maintenance.objects.filter(
            status=MaintenanceStatusChoices.COMPLETED,
            visibility=True,
            last_updated__range=(daterange, datenow_end),
        )

        resolved_incidents_maintenances = []

        date_begin = list(datenow - timezone.timedelta(days=n) for n in range(7))
        date_end = list(datenow_end - timezone.timedelta(days=n) for n in range(7))
        for count in range(7):
            local_list = []
            begin = date_begin[count]
            end = date_end[count]
            for incident in resolved_incidents.filter(last_updated__range=(begin, end)):
                local_list.append(incident)
            for maintenance in resolved_maintenances.filter(last_updated__range=(begin, end)):
                local_list.append(maintenance)

            resolved_incidents_maintenances.append((date_begin[count], local_list))

        components = Component.objects.all()
        degraded_components = list(filter(lambda c: c.status == ComponentStatusChoices.DEGRADED_PERFORMANCE, components))
        partial_components = list(filter(lambda c: c.status == ComponentStatusChoices.PARTIAL_OUTAGE, components))
        major_components = list(filter(lambda c: c.status == ComponentStatusChoices.MAJOR_OUTAGE, components))
        maintenance_components = list(filter(lambda c: c.status == ComponentStatusChoices.MAINTENANCE, components))

        if len(maintenance_components) > 0:
            status = ('bg-blue-200', 'text-blue-800', 'mdi-wrench text-blue-500', 'Some systems are undergoing maintenance')
        elif len(major_components) > 0:
            status = ('bg-red-200', 'text-red-800', 'mdi-alert-circle text-red-500', 'There is a major system outage')
        elif len(partial_components) > 0:
            status = ('bg-orange-200', 'text-orange-800', 'mdi-alert-circle text-orange-500', 'There is a partial system outage')
        elif len(degraded_components) > 0:
            status = ('bg-yellow-200', 'text-yellow-800', 'mdi-alert-circle text-yellow-500', 'Some systems are having perfomance issues')
        else:
            status = ('bg-green-200', 'text-green-800', 'mdi-check-circle text-green-500', 'All systems operational')

        componentgroups_components = list(chain(component_groups, ungrouped_components))

        metrics = Metric.objects.filter(visibility=True)

        return render(request, self.template_name, {
            'component_groups': component_groups,
            'ungrouped_components': ungrouped_components,
            'status': status,
            'open_incidents_maintenances': open_incidents_maintenances,
            'componentgroups_components': componentgroups_components,
            'metrics': metrics,
            'upcoming_maintenances': upcoming_maintenances,
            'resolved_incidents_maintenances': resolved_incidents_maintenances,
        })


class DashboardHomeView(BaseView):
    template_name = 'dashboard/home.html'

    def get(self, request):
        if not request.user.is_authenticated:
            return redirect("login")

        open_incidents = Incident.objects.filter(
            ~Q(status=IncidentStatusChoices.RESOLVED)
        )
        open_maintenances = Maintenance.objects.filter(
            ~Q(status=MaintenanceStatusChoices.COMPLETED)
        )
        upcoming_maintenances = Maintenance.objects.filter(
            ~Q(status=MaintenanceStatusChoices.COMPLETED),
            scheduled_at__gte=timezone.now(),
        )

        return render(request, self.template_name, {
            'open_incidents': len(open_incidents),
            'open_maintenances': len(open_maintenances),
            'upcoming_maintenances': len(upcoming_maintenances),
        })


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

        return render(request, self.template_name, {
            'form': form,
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

        form = PublicSubscriberManagementForm(instance=subscriber, data=request.POST)

        if form.is_valid():
            messages.success(request, 'Successfully updated the Subscription preferences')
            form.save()

        return render(request, self.template_name, {
            'form': form,
            'subscriber': subscriber,
        })


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


@requires_csrf_token
def server_error(request, template_name=ERROR_500_TEMPLATE_NAME):
    """
    Custom 500 handler to provide additional context when rendering 500.html.
    """
    try:
        template = loader.get_template(template_name)
    except TemplateDoesNotExist:
        return HttpResponseServerError('<h1>Server Error (500)</h1>', content_type='text/html')
    type_, error, traceback = sys.exc_info()

    return HttpResponseServerError(template.render({
        'error': error,
        'exception': str(type_),
        'statuspage_version': settings.VERSION,
        'python_version': platform.python_version(),
    }))
