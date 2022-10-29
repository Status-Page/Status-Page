import django_tables2 as tables
from django.conf import settings

from extras.models import *
from statuspage.tables import StatusPageTable, columns
from .template_code import *

__all__ = (
    'ObjectChangeTable',
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
