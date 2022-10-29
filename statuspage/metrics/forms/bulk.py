from django import forms

from statuspage.forms import StatusPageModelBulkEditForm
from utilities.forms import StaticSelect, add_blank_choice, BulkEditNullBooleanSelect
from ..models import Metric
from .. import choices

__all__ = (
    'MetricBulkEditForm',
)


class MetricBulkEditForm(StatusPageModelBulkEditForm):
    visibility = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
        label='Visible',
    )
    order = forms.IntegerField(
        required=False,
    )
    expand = forms.ChoiceField(
        choices=add_blank_choice(choices.MetricExpandChoices),
        required=False,
        widget=StaticSelect(),
    )

    model = Metric
    fieldsets = (
        ('Metric', ('visibility', 'order', 'expand')),
    )
    nullable_fields = ()
