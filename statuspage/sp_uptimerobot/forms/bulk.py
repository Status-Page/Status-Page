from django import forms

from components.models import Component
from metrics.models import Metric
from statuspage.forms import StatusPageModelBulkEditForm
from utilities.forms import StaticSelect, add_blank_choice, BulkEditNullBooleanSelect
from ..models import UptimeRobotMonitor

__all__ = (
    'UptimeRobotMonitorBulkEditForm',
)


class UptimeRobotMonitorBulkEditForm(StatusPageModelBulkEditForm):
    component = forms.ModelChoiceField(
        queryset=Component.objects.all(),
        required=False,
        widget=StaticSelect(),
        label='Component',
    )
    metric = forms.ModelChoiceField(
        queryset=Metric.objects.all(),
        required=False,
        widget=StaticSelect(),
        label='Metric',
    )
    paused = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
    )

    model = UptimeRobotMonitor
    fieldsets = (
        ('UptimeRobot Monitor', ('component', 'metric', 'paused')),
    )
    nullable_fields = ('link', 'component', 'metric')
