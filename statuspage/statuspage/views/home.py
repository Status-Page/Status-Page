from itertools import chain

from django.db.models import Prefetch, Q
from django.shortcuts import render
from django.utils import timezone
from django.utils.translation import gettext_lazy as _

from components.choices import ComponentStatusChoices
from components.models import ComponentGroup, Component
from incidents.choices import IncidentStatusChoices
from incidents.models import Incident
from maintenances.choices import MaintenanceStatusChoices
from maintenances.models import Maintenance
from metrics.models import Metric
from statuspage.config import get_config
from statuspage.views import BaseView


__all__ = (
    'HomeView',
)


class HomeView(BaseView):
    template_name = 'home.html'

    def get(self, request):
        config = get_config()
        component_groups = ComponentGroup.objects.filter(visibility=True)\
            .prefetch_related(Prefetch('components', queryset=Component.objects.filter(visibility=True)),
                              Prefetch('components__incidents', queryset=Incident.objects.filter(visibility=True)))
        ungrouped_components = Component.objects.filter(component_group=None, visibility=True)\
            .prefetch_related(Prefetch('incidents', queryset=Incident.objects.filter(visibility=True)))

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
            for incident in resolved_incidents.filter(created__range=(begin, end)):
                local_list.append(incident)
            for maintenance in resolved_maintenances.filter(created__range=(begin, end)):
                local_list.append(maintenance)

            resolved_incidents_maintenances.append((date_begin[count], local_list))

        components = Component.objects.all()
        degraded_components = list(filter(lambda c: c.status == ComponentStatusChoices.DEGRADED_PERFORMANCE, components))
        partial_components = list(filter(lambda c: c.status == ComponentStatusChoices.PARTIAL_OUTAGE, components))
        major_components = list(filter(lambda c: c.status == ComponentStatusChoices.MAJOR_OUTAGE, components))
        maintenance_components = list(filter(lambda c: c.status == ComponentStatusChoices.MAINTENANCE, components))

        if len(maintenance_components) > 0:
            status = ('bg-blue-200', 'text-blue-800', 'mdi-wrench text-blue-500', _('Some systems are undergoing '
                                                                                    'maintenance'))
        elif len(major_components) > 0:
            status = ('bg-red-200', 'text-red-800', 'mdi-alert-circle text-red-500', _('There is a major system outage'))
        elif len(partial_components) > 0:
            status = ('bg-orange-200', 'text-orange-800', 'mdi-alert-circle text-orange-500', _('There is a partial '
                                                                                                'system outage'))
        elif len(degraded_components) > 0:
            status = ('bg-yellow-200', 'text-yellow-800', 'mdi-alert-circle text-yellow-500', _('Some systems are '
                                                                                                'having perfomance '
                                                                                                'issues'))
        else:
            status = ('bg-green-200', 'text-green-800', 'mdi-check-circle text-green-500', _('All systems operational'))

        componentgroups_components = list(chain(component_groups, ungrouped_components))

        metrics = Metric.objects.filter(visibility=True)

        should_show_history = True
        incident_sum = sum(list(map(lambda x: len(x[1]), resolved_incidents_maintenances)))
        if incident_sum == 0 and config.HIDE_HISTORY_WHEN_EMPTY:
            should_show_history = False

        return render(request, self.template_name, {
            'component_groups': component_groups,
            'ungrouped_components': ungrouped_components,
            'status': status,
            'open_incidents_maintenances': open_incidents_maintenances,
            'componentgroups_components': componentgroups_components,
            'metrics': metrics,
            'upcoming_maintenances': upcoming_maintenances,
            'resolved_incidents_maintenances': resolved_incidents_maintenances,
            'should_show_history': should_show_history,
        })
