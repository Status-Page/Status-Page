from statuspage.forms import StatusPageModelBulkEditForm
from utilities.forms import StaticSelect, StaticSelectMultiple, add_blank_choice, BulkEditNullBooleanSelect, \
    DateTimePicker
from .. import choices
from ..models import Maintenance, MaintenanceUpdate
from django import forms
from components.models import Component

__all__ = (
    'MaintenanceBulkEditForm',
    'MaintenanceUpdateBulkEditForm',
)


class MaintenanceBulkEditForm(StatusPageModelBulkEditForm):
    status = forms.ChoiceField(
        choices=add_blank_choice(choices.MaintenanceStatusChoices),
        required=False,
        widget=StaticSelect(),
    )
    impact = forms.ChoiceField(
        choices=add_blank_choice(choices.MaintenanceImpactChoices),
        required=False,
        widget=StaticSelect(),
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
        label='Visible',
    )
    scheduled_at = forms.DateTimeField(
        required=False,
        widget=DateTimePicker(),
    )
    start_automatically = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
    )
    end_at = forms.DateTimeField(
        required=False,
        widget=DateTimePicker(),
    )
    end_automatically = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
    )
    components = forms.ModelMultipleChoiceField(
        queryset=Component.objects.all(),
        required=False,
        widget=StaticSelectMultiple(),
    )

    model = Maintenance
    fieldsets = (
        ('Maintenance', ('status', 'impact', 'visibility', 'scheduled_at', 'start_automatically', 'end_at',
                         'end_automatically', 'components')),
    )
    nullable_fields = ('components',)


class MaintenanceUpdateBulkEditForm(StatusPageModelBulkEditForm):
    new_status = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
        label='New Status',
    )
    status = forms.ChoiceField(
        choices=add_blank_choice(choices.MaintenanceStatusChoices),
        required=False,
        widget=StaticSelect(),
    )

    model = MaintenanceUpdate
    fieldsets = (
        ('Maintenance Update', ('new_status', 'status',)),
    )
