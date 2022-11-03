import django_filters
from django.db.models import Q


from .models import ExternalStatusPage, ExternalStatusComponent
from statuspage.filtersets import StatusPageModelFilterSet


class ExternalStatusPageFilterSet(StatusPageModelFilterSet):
    class Meta:
        model = ExternalStatusPage
        fields = ['id', 'domain', 'provider', 'create_incidents', 'create_maintenances']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(domain__icontains=value)
        ).distinct()


class ExternalStatusComponentFilterSet(StatusPageModelFilterSet):
    class Meta:
        model = ExternalStatusComponent
        fields = ['id', 'name', 'page_object_id', 'external_page', 'component', 'group_name']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(name__icontains=value)
        ).distinct()
