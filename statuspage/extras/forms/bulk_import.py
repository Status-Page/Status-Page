from django.contrib.contenttypes.models import ContentType
from django.utils.translation import gettext as _

from extras.models import *
from extras.utils import FeatureQuery
from utilities.forms import CSVModelForm
from utilities.forms.fields import CSVMultipleContentTypeField

__all__ = (
    'WebhookImportForm',
)


class WebhookImportForm(CSVModelForm):
    content_types = CSVMultipleContentTypeField(
        queryset=ContentType.objects.all(),
        limit_choices_to=FeatureQuery('webhooks'),
        help_text=_("One or more assigned object types")
    )

    class Meta:
        model = Webhook
        fields = (
            'name', 'subscriber', 'enabled', 'content_types', 'type_create', 'type_update', 'type_delete',
            'payload_url', 'http_method', 'http_content_type', 'additional_headers', 'body_template',
            'secret', 'ssl_verification', 'ca_file_path'
        )
