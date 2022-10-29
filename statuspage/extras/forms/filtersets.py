from django import forms
from django.contrib.auth.models import User
from django.contrib.contenttypes.models import ContentType
from django.utils.translation import gettext as _

from extras.choices import *
from extras.models import *
from utilities.forms import (
    add_blank_choice, APISelectMultiple, DateTimePicker, DynamicModelMultipleChoiceField, FilterForm,
    StaticSelect
)

__all__ = (
    'ObjectChangeFilterForm',
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
