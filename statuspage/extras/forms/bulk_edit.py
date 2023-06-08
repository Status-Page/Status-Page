from django import forms
from django.utils.translation import gettext as _

from extras.choices import *
from extras.models import *
from subscribers.models import Subscriber
from utilities.forms import BulkEditForm, add_blank_choice
from utilities.forms.widgets import BulkEditNullBooleanSelect

__all__ = (
    'WebhookBulkEditForm',
)


class WebhookBulkEditForm(BulkEditForm):
    pk = forms.ModelMultipleChoiceField(
        queryset=Webhook.objects.all(),
        widget=forms.MultipleHiddenInput
    )
    subscriber = forms.ModelChoiceField(
        queryset=Subscriber.objects.all(),
        required=False,
    )
    enabled = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect()
    )
    type_create = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect()
    )
    type_update = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect()
    )
    type_delete = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect()
    )
    http_method = forms.ChoiceField(
        choices=add_blank_choice(WebhookHttpMethodChoices),
        required=False,
        label=_('HTTP method')
    )
    payload_url = forms.CharField(
        required=False,
        label=_('Payload URL')
    )
    ssl_verification = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect(),
        label=_('SSL verification')
    )
    secret = forms.CharField(
        required=False
    )
    ca_file_path = forms.CharField(
        required=False,
        label=_('CA file path')
    )

    nullable_fields = ('secret', 'conditions', 'ca_file_path')
