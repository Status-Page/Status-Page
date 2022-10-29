from django import forms

from ..models import Metric
from ..choices import MetricExpandChoices
from utilities.forms import FilterForm, StaticSelect, add_blank_choice, \
    BOOLEAN_WITH_BLANK_CHOICES

__all__ = (
    'MetricFilterForm',
)


class MetricFilterForm(FilterForm):
    model = Metric
    fieldsets = (
        (None, ('q',)),
        ('Metric', ('title', 'suffix', 'visibility', 'order', 'expand')),
    )
    title = forms.CharField(
        required=False,
    )
    suffix = forms.CharField(
        required=False,
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    order = forms.IntegerField(
        required=False,
    )
    expand = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(MetricExpandChoices),
        widget=StaticSelect(),
    )
