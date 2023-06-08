from django import forms
from django.contrib.auth.models import User
from django.contrib.contenttypes.models import ContentType
from django.utils.translation import gettext as _

from extras.choices import *
from extras.models import *
from extras.utils import FeatureQuery
from subscribers.models import Subscriber
from utilities.forms import (
    add_blank_choice, APISelectMultiple, DateTimePicker, DynamicModelMultipleChoiceField, FilterForm,
    StaticSelect, ContentTypeMultipleChoiceField, BOOLEAN_WITH_BLANK_CHOICES
)

__all__ = (
    'ObjectChangeFilterForm',
    'WebhookFilterForm',
)


class WebhookFilterForm(FilterForm):
    fieldsets = (
        (None, ('q',)),
        ('Attributes', ('subscriber', 'content_type_id', 'http_method', 'enabled')),
        ('Events', ('type_create', 'type_update', 'type_delete')),
    )
    subscriber = forms.ModelChoiceField(
        queryset=Subscriber.objects.all(),
        required=False,
    )
    content_type_id = ContentTypeMultipleChoiceField(
        queryset=ContentType.objects.filter(FeatureQuery('webhooks').get_query()),
        required=False,
        label=_('Object type')
    )
    http_method = forms.MultipleChoiceField(
        choices=WebhookHttpMethodChoices,
        required=False,
        label=_('HTTP method')
    )
    enabled = forms.NullBooleanField(
        required=False,
        widget=forms.Select(
            choices=BOOLEAN_WITH_BLANK_CHOICES
        )
    )
    type_create = forms.NullBooleanField(
        required=False,
        widget=forms.Select(
            choices=BOOLEAN_WITH_BLANK_CHOICES
        ),
        label=_('Object creations')
    )
    type_update = forms.NullBooleanField(
        required=False,
        widget=forms.Select(
            choices=BOOLEAN_WITH_BLANK_CHOICES
        ),
        label=_('Object updates')
    )
    type_delete = forms.NullBooleanField(
        required=False,
        widget=forms.Select(
            choices=BOOLEAN_WITH_BLANK_CHOICES
        ),
        label=_('Object deletions')
    )


class ObjectChangeFilterForm(FilterForm):
    model = ObjectChange
    fieldsets = (
        (None, ('q',)),
        ('Time', ('time_before', 'time_after')),
        ('Attributes', ('action', 'user_id', 'changed_object_type_id')),
    )
    time_after = forms.DateTimeField(
        required=False,
        label=_('After'),
        widget=DateTimePicker()
    )
    time_before = forms.DateTimeField(
        required=False,
        label=_('Before'),
        widget=DateTimePicker()
    )
    action = forms.ChoiceField(
        choices=add_blank_choice(ObjectChangeActionChoices),
        required=False,
        widget=StaticSelect()
    )
    user_id = DynamicModelMultipleChoiceField(
        queryset=User.objects.all(),
        required=False,
        label=_('User'),
        widget=APISelectMultiple(
            api_url='/api/users/users/',
        )
    )
    changed_object_type_id = DynamicModelMultipleChoiceField(
        queryset=ContentType.objects.all(),
        required=False,
        label=_('Object Type'),
        widget=APISelectMultiple(
            api_url='/api/extras/content-types/',
        )
    )
