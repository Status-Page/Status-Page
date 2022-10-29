import django_filters
from django.contrib.auth.models import User
from django.db.models import Q

from incidents.models import Incident
from components.models import Component
from statuspage.filtersets import StatusPageModelFilterSet


class IncidentFilterSet(StatusPageModelFilterSet):
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
        model = Incident
        fields = ['id', 'title', 'status', 'impact', 'visibility']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(title__icontains=value)
        ).distinct()
