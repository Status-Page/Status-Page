import django_filters
from django.db.models import Q

from components.models import Component
from metrics.models import Metric
from sp_uptimerobot.models import UptimeRobotMonitor
from statuspage.filtersets import StatusPageModelFilterSet


class UptimeRobotMonitorFilterSet(StatusPageModelFilterSet):
    component = django_filters.ModelMultipleChoiceFilter(
        field_name='component__name',
        queryset=Component.objects.all(),
        to_field_name='name',
        label='Component (Name)',
    )
    component_id = django_filters.ModelMultipleChoiceFilter(
        field_name='component__id',
        queryset=Component.objects.all(),
        to_field_name='id',
        label='Component (Id)',
    )

    metric = django_filters.ModelMultipleChoiceFilter(
        field_name='metric__title',
        queryset=Metric.objects.all(),
        to_field_name='title',
        label='Metric (Title)',
    )
    metric_id = django_filters.ModelMultipleChoiceFilter(
        field_name='metric__id',
        queryset=Metric.objects.all(),
        to_field_name='id',
        label='Metric (Id)',
    )

    class Meta:
        model = UptimeRobotMonitor
        fields = ['id', 'monitor_id', 'friendly_name', 'status_id', 'paused']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(friendly_name__icontains=value)
        ).distinct()
