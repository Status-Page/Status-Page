from django import forms
from django.contrib.contenttypes.models import ContentType

from extras.models import *
from extras.utils import FeatureQuery
from utilities.forms import TailwindMixin
from utilities.forms.fields import ContentTypeMultipleChoiceField

__all__ = (
    'WebhookForm',
    'PublicWebhookForm',
)


class WebhookForm(TailwindMixin, forms.ModelForm):
    content_types = ContentTypeMultipleChoiceField(
        queryset=ContentType.objects.all(),
        limit_choices_to=FeatureQuery('webhooks')
    )

    fieldsets = (
        ('Webhook', ('name', 'subscriber', 'content_types', 'enabled')),
        ('Events', ('type_create', 'type_update', 'type_delete')),
        ('HTTP Request', (
            'payload_url', 'http_method', 'http_content_type', 'additional_headers', 'body_template', 'secret',
        )),
        ('Conditions', ('conditions',)),
        ('SSL', ('ssl_verification', 'ca_file_path')),
    )

    class Meta:
        model = Webhook
        fields = '__all__'
        labels = {
            'type_create': 'Creations',
            'type_update': 'Updates',
            'type_delete': 'Deletions',
        }
        widgets = {
            'additional_headers': forms.Textarea(attrs={'class': 'font-mono'}),
            'body_template': forms.Textarea(attrs={'class': 'font-mono'}),
            'conditions': forms.Textarea(attrs={'class': 'font-mono'}),
        }


class PublicWebhookForm(TailwindMixin, forms.ModelForm):
    fieldsets = (
        ('Webhook', ('name',)),
        ('Events', ('type_create', 'type_update', 'type_delete')),
        ('HTTP Request', (
            'payload_url', 'http_method', 'http_content_type', 'additional_headers', 'body_template', 'secret',
        )),
        ('SSL', ('ssl_verification',)),
    )

    class Meta:
        model = Webhook
        fields = ('name', 'type_create', 'type_update', 'type_delete', 'payload_url', 'http_method', 'conditions',
                  'http_content_type', 'additional_headers', 'body_template', 'secret', 'ssl_verification')
        labels = {
            'type_create': 'Creations',
            'type_update': 'Updates',
            'type_delete': 'Deletions',
        }
        widgets = {
            'additional_headers': forms.Textarea(attrs={'class': 'font-mono'}),
            'body_template': forms.Textarea(attrs={'class': 'font-mono'}),
            'conditions': forms.HiddenInput(),
        }
