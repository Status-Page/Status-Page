from django import forms

from ..models import Subscriber
from utilities.forms import FilterForm

__all__ = (
    'SubscriberFilterForm',
)


class SubscriberFilterForm(FilterForm):
    model = Subscriber
    fieldsets = (
        (None, ('q',)),
        ('Subscriber', ('email',)),
    )
    email = forms.CharField(
        required=False,
    )
