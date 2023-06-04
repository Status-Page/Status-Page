import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns, TruncatedTextColumn
from .models import Maintenance, MaintenanceUpdate, MaintenanceTemplate


class MaintenanceTable(StatusPageTable):
    title = tables.Column(
        linkify=True,
    )
    status = tables.Column()
    impact = columns.ChoiceFieldColumn()
    visibility = columns.BooleanColumn()
    scheduled_at = columns.DateTimeColumn()
    end_at = columns.DateTimeColumn()
    user = tables.Column()

    class Meta(StatusPageTable.Meta):
        model = Maintenance
        fields = ('pk', 'id', 'title', 'status', 'impact', 'visibility', 'scheduled_at', 'end_at', 'user', 'created',
                  'last_updated')
        default_columns = ('id', 'title', 'status', 'impact', 'visibility', 'scheduled_at', 'end_at', 'user')


class MaintenanceUpdateTable(StatusPageTable):
    text = TruncatedTextColumn(
        linkify=True,
    )
    new_status = columns.BooleanColumn()
    status = tables.Column()
    user = tables.Column()

    class Meta(StatusPageTable.Meta):
        model = MaintenanceUpdate
        fields = ('pk', 'id', 'text', 'new_status', 'status', 'user', 'created', 'last_updated')
        default_columns = ('id', 'text', 'new_status', 'status', 'user')


class MaintenanceTemplateTable(StatusPageTable):
    template_name = tables.Column(
        linkify=True,
    )
    title = tables.Column()
    status = tables.Column()
    impact = columns.ChoiceFieldColumn()
    visibility = columns.BooleanColumn()
    start_automatically = columns.BooleanColumn()
    end_automatically = columns.BooleanColumn()
    update_component_status = columns.BooleanColumn()

    class Meta(StatusPageTable.Meta):
        model = MaintenanceTemplate
        fields = ('pk', 'id', 'template_name', 'title', 'status', 'impact', 'visibility', 'start_automatically',
                  'end_automatically', 'update_component_status', 'created', 'last_updated')
        default_columns = ('id', 'template_name', 'status', 'impact', 'visibility', 'start_automatically',
                           'end_automatically')
