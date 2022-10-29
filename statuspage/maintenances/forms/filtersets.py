from django import forms
from django.contrib.auth.models import User

from components.models import Component
from ..models import Maintenance
from ..choices import MaintenanceStatusChoices, MaintenanceImpactChoices
from utilities.forms import FilterForm, StaticSelect, add_blank_choice, \
    BOOLEAN_WITH_BLANK_CHOICES, StaticSelectMultiple, DateTimePicker

__all__ = (
    'MaintenanceFilterForm',
)


class MaintenanceFilterForm(FilterForm):
    model = Maintenance
    fieldsets = (
        (None, ('q',)),
        ('Maintenance', ('title', 'status', 'impact', 'visibility', 'scheduled_at', 'start_automatically', 'end_at',
                         'end_automatically', 'user_id', 'component_id')),
    )
    title = forms.CharField(
        required=False,
    )
    status = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(MaintenanceStatusChoices),
        widget=StaticSelect(),
    )
    impact = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(MaintenanceImpactChoices),
        widget=StaticSelect(),
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    scheduled_at = forms.DateTimeField(
        required=False,
        widget=DateTimePicker(),
    )
    start_automatically = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    end_at = forms.DateTimeField(
        required=False,
        widget=DateTimePicker(),
    )
    end_automatically = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    user_id = forms.ModelChoiceField(
        required=False,
        queryset=User.objects.all(),
        widget=StaticSelect(),
        label='User',
    )
    component_id = forms.ModelMultipleChoiceField(
        required=False,
        queryset=Component.objects.all(),
        widget=StaticSelectMultiple(),
        label='Components',
    )
