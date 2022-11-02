from django import forms

from components.choices import ComponentStatusChoices
from components.models import Component
from metrics.models import Metric
from ..models import UptimeRobotMonitor
from utilities.forms import FilterForm, StaticSelect, add_blank_choice, \
    BOOLEAN_WITH_BLANK_CHOICES

__all__ = (
    'UptimeRobotMonitorFilterForm',
)


class UptimeRobotMonitorFilterForm(FilterForm):
    model = UptimeRobotMonitor
    fieldsets = (
        (None, ('q',)),
        ('UptimeRobot Monitor', ('monitor_id', 'friendly_name', 'status', 'component_id', 'metric_id', 'paused')),
    )
    monitor_id = forms.CharField(
        required=False,
    )
    friendly_name = forms.CharField(
        required=False,
    )
    status = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(ComponentStatusChoices),
        widget=StaticSelect(),
    )
    component_id = forms.ModelChoiceField(
        required=False,
        queryset=Component.objects.all(),
        widget=StaticSelect(),
    )
    metric_id = forms.ModelChoiceField(
        required=False,
        queryset=Metric.objects.all(),
        widget=StaticSelect(),
    )
    paused = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
