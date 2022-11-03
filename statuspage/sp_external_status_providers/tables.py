import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns
from .models import ExternalStatusPage, ExternalStatusComponent


class ExternalStatusPageTable(StatusPageTable):
    domain = tables.Column(
        linkify=True,
    )
    create_incidents = columns.BooleanColumn()
    create_maintenances = columns.BooleanColumn()

    class Meta(StatusPageTable.Meta):
        model = ExternalStatusPage
        fields = ('pk', 'id', 'domain', 'provider', 'create_incidents', 'create_maintenances')
        default_columns = ('pk', 'domain', 'provider', 'create_incidents', 'create_maintenances')


class ExternalStatusComponentTable(StatusPageTable):
    name = tables.Column(
        linkify=True,
    )

    class Meta(StatusPageTable.Meta):
        model = ExternalStatusComponent
        fields = ('pk', 'id', 'page_object_id', 'name', 'external_page', 'group_name', 'component')
        default_columns = ('pk', 'name', 'external_page', 'group_name', 'component')
