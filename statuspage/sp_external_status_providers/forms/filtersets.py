from django import forms

from components.models import Component
from ..choices import ExternalStatusPageProviderChoices
from ..models import ExternalStatusPage, ExternalStatusComponent
from utilities.forms import FilterForm, StaticSelect, add_blank_choice, \
    BOOLEAN_WITH_BLANK_CHOICES

__all__ = (
    'ExternalStatusPageFilterForm',
    'ExternalStatusComponentFilterForm',
)


class ExternalStatusPageFilterForm(FilterForm):
    model = ExternalStatusPage
    fieldsets = (
        (None, ('q',)),
        ('Page', ('provider', 'create_incidents', 'create_maintenances')),
    )
    provider = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(ExternalStatusPageProviderChoices),
        widget=StaticSelect(),
    )
    create_incidents = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    create_maintenances = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )


class ExternalStatusComponentFilterForm(FilterForm):
    model = ExternalStatusComponent
    fieldsets = (
        (None, ('q',)),
        ('Component', ('external_page', 'component')),
    )
    external_page = forms.ModelChoiceField(
        queryset=ExternalStatusPage.objects.all(),
        widget=StaticSelect(),
    )
    component = forms.ModelChoiceField(
        queryset=Component.objects.all(),
        widget=StaticSelect(),
    )
