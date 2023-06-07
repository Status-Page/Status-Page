import json

from django.conf import settings
from django.contrib import admin
from django.contrib.contenttypes.models import ContentType
from django.core.cache import cache
from django.core.exceptions import ValidationError
from django.db import models
from django.urls import reverse
from django.utils.translation import gettext as _
from rest_framework.utils.encoders import JSONEncoder

from extras.choices import WebhookHttpMethodChoices
from extras.conditions import ConditionSet
from extras.constants import HTTP_CONTENT_TYPE_JSON
from extras.utils import FeatureQuery
from statuspage.models import ChangeLoggedModel

__all__ = (
    'Webhook',
    'ConfigRevision',
)

from utilities.utils import render_jinja2


class Webhook(ChangeLoggedModel):
    """
    A Webhook defines a request that will be sent to a remote application when an object is created, updated, and/or
    delete in NetBox. The request will contain a representation of the object, which the remote application can act on.
    Each Webhook can be limited to firing only on certain actions or certain object types.
    """
    content_types = models.ManyToManyField(
        to=ContentType,
        related_name='webhooks',
        verbose_name='Object types',
        limit_choices_to=FeatureQuery('webhooks'),
        help_text=_("The object(s) to which this Webhook applies.")
    )
    name = models.CharField(
        max_length=150,
        unique=True
    )
    type_create = models.BooleanField(
        default=False,
        help_text=_("Triggers when a matching object is created.")
    )
    type_update = models.BooleanField(
        default=False,
        help_text=_("Triggers when a matching object is updated.")
    )
    type_delete = models.BooleanField(
        default=False,
        help_text=_("Triggers when a matching object is deleted.")
    )
    payload_url = models.CharField(
        max_length=500,
        verbose_name='URL',
        help_text=_('This URL will be called using the HTTP method defined when the webhook is called. '
                    'Jinja2 template processing is supported with the same context as the request body.')
    )
    enabled = models.BooleanField(
        default=True
    )
    http_method = models.CharField(
        max_length=30,
        choices=WebhookHttpMethodChoices,
        default=WebhookHttpMethodChoices.METHOD_POST,
        verbose_name='HTTP method'
    )
    http_content_type = models.CharField(
        max_length=100,
        default=HTTP_CONTENT_TYPE_JSON,
        verbose_name='HTTP content type',
        help_text=_('The complete list of official content types is available '
                    '<a href="https://www.iana.org/assignments/media-types/media-types.xhtml">here</a>.')
    )
    additional_headers = models.TextField(
        blank=True,
        help_text=_("User-supplied HTTP headers to be sent with the request in addition to the HTTP content type. "
                    "Headers should be defined in the format <code>Name: Value</code>. Jinja2 template processing is "
                    "supported with the same context as the request body (below).")
    )
    body_template = models.TextField(
        blank=True,
        help_text=_('Jinja2 template for a custom request body. If blank, a JSON object representing the change will be'
                    ' included. Available context data includes: <code>event</code>, <code>model</code>, '
                    '<code>timestamp</code>, <code>username</code>, <code>request_id</code>, and <code>data</code>.')
    )
    secret = models.CharField(
        max_length=255,
        blank=True,
        help_text=_("When provided, the request will include a 'X-Hook-Signature' "
                    "header containing a HMAC hex digest of the payload body using "
                    "the secret as the key. The secret is not transmitted in "
                    "the request.")
    )
    conditions = models.JSONField(
        blank=True,
        null=True,
        help_text=_("A set of conditions which determine whether the webhook will be generated.")
    )
    ssl_verification = models.BooleanField(
        default=True,
        verbose_name='SSL verification',
        help_text=_("Enable SSL certificate verification. Disable with caution!")
    )
    ca_file_path = models.CharField(
        max_length=4096,
        null=True,
        blank=True,
        verbose_name='CA File Path',
        help_text=_('The specific CA certificate file to use for SSL verification. '
                    'Leave blank to use the system defaults.')
    )

    class Meta:
        ordering = ('name',)
        constraints = (
            models.UniqueConstraint(
                fields=('payload_url', 'type_create', 'type_update', 'type_delete'),
                name='%(app_label)s_%(class)s_unique_payload_url_types'
            ),
        )

    def __str__(self):
        return self.name

    def get_absolute_url(self):
        return reverse('extras:webhook', args=[self.pk])

    @property
    def docs_url(self):
        return f'{settings.STATIC_URL}docs/models/extras/webhook/'

    def clean(self):
        super().clean()

        # At least one action type must be selected
        if not any([
            self.type_create, self.type_update, self.type_delete
        ]):
            raise ValidationError(
                "At least one event type must be selected: create, update and/or delete."
            )

        if self.conditions:
            try:
                ConditionSet(self.conditions)
            except ValueError as e:
                raise ValidationError({'conditions': e})

        # CA file path requires SSL verification enabled
        if not self.ssl_verification and self.ca_file_path:
            raise ValidationError({
                'ca_file_path': 'Do not specify a CA certificate file if SSL verification is disabled.'
            })

    def render_headers(self, context):
        """
        Render additional_headers and return a dict of Header: Value pairs.
        """
        if not self.additional_headers:
            return {}
        ret = {}
        data = render_jinja2(self.additional_headers, context)
        for line in data.splitlines():
            header, value = line.split(':', 1)
            ret[header.strip()] = value.strip()
        return ret

    def render_body(self, context):
        """
        Render the body template, if defined. Otherwise, jump the context as a JSON object.
        """
        if self.body_template:
            return render_jinja2(self.body_template, context)
        else:
            return json.dumps(context, cls=JSONEncoder)

    def render_payload_url(self, context):
        """
        Render the payload URL.
        """
        return render_jinja2(self.payload_url, context)


class ConfigRevision(models.Model):
    """
    An atomic revision of Status-Page's configuration.
    """
    created = models.DateTimeField(
        auto_now_add=True
    )
    comment = models.CharField(
        max_length=200,
        blank=True
    )
    data = models.JSONField(
        blank=True,
        null=True,
        verbose_name='Configuration data'
    )

    def __str__(self):
        return f'Config revision #{self.pk} ({self.created})'

    def __getattr__(self, item):
        if item in self.data:
            return self.data[item]
        return super().__getattribute__(item)

    def activate(self):
        """
        Cache the configuration data.
        """
        cache.set('config', self.data, None)
        cache.set('config_version', self.pk, None)

    @admin.display(boolean=True)
    def is_active(self):
        return cache.get('config_version') == self.pk
