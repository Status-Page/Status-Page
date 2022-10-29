import django_filters
from django.db.models import Q

from components.models import Component, ComponentGroup
from statuspage.filtersets import StatusPageModelFilterSet


class ComponentGroupFilterSet(StatusPageModelFilterSet):
    class Meta:
        model = ComponentGroup
        fields = ['id', 'name', 'description', 'visibility', 'order', 'collapse']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(name__icontains=value)
        ).distinct()


class ComponentFilterSet(StatusPageModelFilterSet):
    component_group = django_filters.ModelMultipleChoiceFilter(
        field_name='component_group__name',
        queryset=ComponentGroup.objects.all(),
        to_field_name='name',
        label='Component Group (Name)',
    )
    component_group_id = django_filters.ModelMultipleChoiceFilter(
        field_name='component_group__id',
        queryset=ComponentGroup.objects.all(),
        to_field_name='id',
        label='Component Group (Id)',
    )

    class Meta:
        model = Component
        fields = ['id', 'name', 'link', 'description', 'visibility', 'status', 'order']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(name__icontains=value)
        ).distinct()
