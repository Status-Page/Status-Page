from django import forms
from django.contrib.auth.models import User

from components.models import Component
from incidents.models import Incident, IncidentTemplate
from incidents.choices import IncidentStatusChoices, IncidentImpactChoices
from utilities.forms import FilterForm, StaticSelect, add_blank_choice, \
    BOOLEAN_WITH_BLANK_CHOICES, StaticSelectMultiple

__all__ = (
    'IncidentFilterForm',
    'IncidentTemplateFilterForm',
)


class IncidentFilterForm(FilterForm):
    model = Incident
    fieldsets = (
        (None, ('q',)),
        ('Incident', ('title', 'status', 'impact', 'visibility', 'user_id', 'component_id')),
    )
    title = forms.CharField(
        required=False,
    )
    status = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(IncidentStatusChoices),
        widget=StaticSelect(),
    )
    impact = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(IncidentImpactChoices),
        widget=StaticSelect(),
    )
    visibility = forms.NullBooleanField(
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


class IncidentTemplateFilterForm(FilterForm):
    model = IncidentTemplate
    fieldsets = (
        (None, ('q',)),
        ('Incident Template', ('template_name', 'title', 'status', 'impact', 'visibility', 'component_id',
                               'update_component_status')),
    )
    template_name = forms.CharField(
        required=False,
    )
    title = forms.CharField(
        required=False,
    )
    status = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(IncidentStatusChoices),
        widget=StaticSelect(),
    )
    impact = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(IncidentImpactChoices),
        widget=StaticSelect(),
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    component_id = forms.ModelMultipleChoiceField(
        required=False,
        queryset=Component.objects.all(),
        widget=StaticSelectMultiple(),
        label='Components',
    )
    update_component_status = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
