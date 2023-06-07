import django_filters
from django.contrib.auth.models import User
from django.contrib.contenttypes.models import ContentType
from django.db.models import Q
from django.utils.translation import gettext as _

from statuspage.filtersets import BaseFilterSet
from utilities.filters import ContentTypeFilter, MultiValueNumberFilter
from .choices import WebhookHttpMethodChoices
from .models import *


__all__ = (
    'ContentTypeFilterSet',
    'ObjectChangeFilterSet',
    'WebhookFilterSet',
)


class WebhookFilterSet(BaseFilterSet):
    q = django_filters.CharFilter(
        method='search',
        label=_('Search'),
    )
    content_type_id = MultiValueNumberFilter(
        field_name='content_types__id'
    )
    content_types = ContentTypeFilter()
    http_method = django_filters.MultipleChoiceFilter(
        choices=WebhookHttpMethodChoices
    )

    class Meta:
        model = Webhook
        fields = [
            'id', 'name', 'type_create', 'type_update', 'type_delete', 'payload_url',
            'enabled', 'http_method', 'http_content_type', 'secret', 'ssl_verification', 'ca_file_path',
        ]

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(name__icontains=value) |
            Q(payload_url__icontains=value)
        )


class ObjectChangeFilterSet(BaseFilterSet):
    q = django_filters.CharFilter(
        method='search',
        label='Search',
    )
    time = django_filters.DateTimeFromToRangeFilter()
    changed_object_type = ContentTypeFilter()
    user_id = django_filters.ModelMultipleChoiceFilter(
        queryset=User.objects.all(),
        label='User (Id)',
    )
    user = django_filters.ModelMultipleChoiceFilter(
        field_name='user__username',
        queryset=User.objects.all(),
        to_field_name='username',
        label='User name',
    )

    class Meta:
        model = ObjectChange
        fields = [
            'id', 'user', 'user_name', 'request_id', 'action', 'changed_object_type_id', 'changed_object_id',
            'object_repr',
        ]

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(user_name__icontains=value) |
            Q(object_repr__icontains=value)
        )


#
# ContentTypes
#

class ContentTypeFilterSet(django_filters.FilterSet):
    q = django_filters.CharFilter(
        method='search',
        label='Search',
    )

    class Meta:
        model = ContentType
        fields = ['id', 'app_label', 'model']

    def search(self, queryset, name, value):
        if not value.strip():
            return queryset
        return queryset.filter(
            Q(app_label__icontains=value) |
            Q(model__icontains=value)
        )
