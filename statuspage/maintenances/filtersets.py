import django_filters
from django.contrib.auth.models import User
from django.db.models import Q

from .models import Maintenance, MaintenanceUpdate
from components.models import Component
from statuspage.filtersets import StatusPageModelFilterSet


class MaintenanceFilterSet(StatusPageModelFilterSet):
    user = django_filters.ModelMultipleChoiceFilter(
        field_name='user__username',
        queryset=User.objects.all(),
        to_field_name='username',
        label='User (Username)',
    )
    user_id = django_filters.ModelMultipleChoiceFilter(
        field_name='user__id',
        queryset=User.objects.all(),
        to_field_name='id',
        label='User (Id)',
    )

    component = django_filters.ModelMultipleChoiceFilter(
        field_name='components__name',
        queryset=Component.objects.all(),
        to_field_name='name',
        conjoined=True,
        label='Component (Name)',
    )
    component_id = django_filters.ModelMultipleChoiceFilter(
        field_name='components__id',
        queryset=Component.objects.all(),
        to_field_name='id',
        conjoined=True,
        label='Component (Id)',
    )

    class Meta:
        model = Maintenance
        fields = ['id', 'title', 'status', 'impact', 'scheduled_at', 'end_at', 'visibility']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(title__icontains=value)
        ).distinct()


class MaintenanceUpdateFilterSet(StatusPageModelFilterSet):
    user = django_filters.ModelMultipleChoiceFilter(
        field_name='user__username',
        queryset=User.objects.all(),
        to_field_name='username',
        label='User (Username)',
    )
    user_id = django_filters.ModelMultipleChoiceFilter(
        field_name='user__id',
        queryset=User.objects.all(),
        to_field_name='id',
        label='User (Id)',
    )

    maintenance = django_filters.ModelMultipleChoiceFilter(
        field_name='maintenance__title',
        queryset=Maintenance.objects.all(),
        to_field_name='title',
        conjoined=True,
        label='Maintenance (Title)',
    )
    maintenance_id = django_filters.ModelMultipleChoiceFilter(
        field_name='maintenance__id',
        queryset=Maintenance.objects.all(),
        to_field_name='id',
        conjoined=True,
        label='Maintenance (Id)',
    )

    class Meta:
        model = MaintenanceUpdate
        fields = ['id', 'text', 'status', 'new_status']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(text__icontains=value)
        ).distinct()
