import django_filters
from django.db.models import Q

from .models import Metric, MetricPoint
from statuspage.filtersets import StatusPageModelFilterSet


class MetricFilterSet(StatusPageModelFilterSet):
    class Meta:
        model = Metric
        fields = ['id', 'title', 'suffix', 'visibility', 'order', 'expand']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(title__icontains=value)
        ).distinct()


class MetricPointFilterSet(StatusPageModelFilterSet):
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
        model = MetricPoint
        fields = ['id', 'value']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(value__icontains=value)
        ).distinct()
