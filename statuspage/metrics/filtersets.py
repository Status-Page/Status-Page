from django.db.models import Q

from .models import Metric
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
