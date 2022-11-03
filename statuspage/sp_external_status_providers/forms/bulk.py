from django import forms

from components.models import Component
from statuspage.forms import StatusPageModelBulkEditForm
from utilities.forms import StaticSelect, BulkEditNullBooleanSelect
from ..choices import ExternalStatusPageProviderChoices
from ..models import ExternalStatusPage

__all__ = (
    'ExternalStatusPageBulkEditForm',
    'ExternalStatusComponentBulkEditForm',
)


class ExternalStatusPageBulkEditForm(StatusPageModelBulkEditForm):
    provider = forms.ChoiceField(
        choices=ExternalStatusPageProviderChoices,
        required=False,
        widget=StaticSelect(),
    )
    create_incidents = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
    )
    create_maintenances = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
    )

    model = ExternalStatusPage
    fieldsets = (
        ('Page', ('provider', 'create_incidents', 'create_maintenances')),
    )
    nullable_fields = ()


class ExternalStatusComponentBulkEditForm(StatusPageModelBulkEditForm):
    component = forms.ModelChoiceField(
        queryset=Component.objects.all(),
        required=False,
        widget=StaticSelect(),
    )

    model = ExternalStatusPage
    fieldsets = (
        ('Page', ('component',)),
    )
    nullable_fields = ('component',)
