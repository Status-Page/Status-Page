from django.db.models import Q

from .models import Subscriber
from statuspage.filtersets import StatusPageModelFilterSet


class SubscriberFilterSet(StatusPageModelFilterSet):
    class Meta:
        model = Subscriber
        fields = ['id', 'email']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(email__icontains=value)
        ).distinct()
