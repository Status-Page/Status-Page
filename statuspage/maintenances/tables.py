import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns
from .models import Maintenance, MaintenanceUpdate


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
    text = tables.Column(
        linkify=True,
    )
    new_status = columns.BooleanColumn()
    status = tables.Column()
    user = tables.Column()

    class Meta(StatusPageTable.Meta):
        model = MaintenanceUpdate
        fields = ('pk', 'id', 'text', 'new_status', 'status', 'user', 'created', 'last_updated')
        default_columns = ('id', 'text', 'new_status', 'status', 'user')
