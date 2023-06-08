import django_tables2 as tables
from django.conf import settings

from extras.models import *
from statuspage.tables import StatusPageTable, columns
from .template_code import *

__all__ = (
    'ObjectChangeTable',
    'WebhookTable',
    'PublicWebhookTable',
)


class WebhookTable(StatusPageTable):
    name = tables.Column(
        linkify=True
    )
    subscriber = tables.Column()
    content_types = columns.ContentTypesColumn()
    enabled = columns.BooleanColumn()
    type_create = columns.BooleanColumn(
        verbose_name='Create'
    )
    type_update = columns.BooleanColumn(
        verbose_name='Update'
    )
    type_delete = columns.BooleanColumn(
        verbose_name='Delete'
    )
    ssl_validation = columns.BooleanColumn(
        verbose_name='SSL Validation'
    )

    class Meta(StatusPageTable.Meta):
        model = Webhook
        fields = (
            'pk', 'id', 'name', 'subscriber', 'content_types', 'enabled', 'type_create', 'type_update', 'type_delete',
            'http_method', 'payload_url', 'secret', 'ssl_validation', 'ca_file_path',
            'created', 'last_updated',
        )
        default_columns = (
            'pk', 'name', 'subscriber', 'content_types', 'enabled', 'type_create', 'type_update', 'type_delete',
            'http_method', 'payload_url',
        )


class PublicWebhookTable(StatusPageTable):
    name = tables.Column()
    content_types = columns.ContentTypesColumn()
    actions = columns.ActionsColumn(
        actions=(),
        extra_buttons=' '.join([
            '<a class="px-2 py-1 rounded-md bg-yellow-500 hover:bg-yellow-400" href="{% url \'subscriber_manage_webhook_edit\' webhook=record.pk management_key=record.subscriber.management_key %}" type="button"><i class="mdi mdi-pencil"></i></a>',
            '<a class="px-2 py-1 rounded-md bg-red-500 hover:bg-red-400" href="{% url \'subscriber_manage_webhook_delete\' webhook=record.pk management_key=record.subscriber.management_key %}" type="button"><i class="mdi mdi-trash-can-outline"></i></a>',
        ]),
    )

    class Meta(StatusPageTable.Meta):
        model = Webhook
        fields = (
            'pk', 'name', 'content_types', 'payload_url',
        )
        default_columns = (
            'pk', 'name', 'content_types', 'payload_url',
        )


class ObjectChangeTable(StatusPageTable):
    time = tables.DateTimeColumn(
        linkify=True,
        format=settings.SHORT_DATETIME_FORMAT
    )
    user_name = tables.Column(
        verbose_name='Username'
    )
    full_name = tables.TemplateColumn(
        accessor=tables.A('user'),
        template_code=OBJECTCHANGE_FULL_NAME,
        verbose_name='Full Name',
        orderable=False
    )
    action = columns.ChoiceFieldColumn()
    changed_object_type = columns.ContentTypeColumn(
        verbose_name='Type'
    )
    object_repr = tables.TemplateColumn(
        accessor=tables.A('changed_object'),
        template_code=OBJECTCHANGE_OBJECT,
        verbose_name='Object'
    )
    request_id = tables.TemplateColumn(
        template_code=OBJECTCHANGE_REQUEST_ID,
        verbose_name='Request Id'
    )
    actions = columns.ActionsColumn(
        actions=()
    )

    class Meta(StatusPageTable.Meta):
        model = ObjectChange
        fields = (
            'pk', 'id', 'time', 'user_name', 'full_name', 'action', 'changed_object_type', 'object_repr', 'request_id',
            'actions',
        )
