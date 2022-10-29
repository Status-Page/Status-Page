import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns
from .models import Incident, IncidentUpdate


class IncidentTable(StatusPageTable):
    title = tables.Column(
        linkify=True,
    )
    status = tables.Column()
    impact = columns.ChoiceFieldColumn()
    visibility = columns.BooleanColumn()
    user = tables.Column()

    class Meta(StatusPageTable.Meta):
        model = Incident
        fields = ('pk', 'id', 'title', 'status', 'impact', 'visibility', 'user', 'created', 'last_updated')
        default_columns = ('id', 'title', 'status', 'impact', 'visibility', 'user')


class IncidentUpdateTable(StatusPageTable):
    text = tables.Column(
        linkify=True,
    )
    new_status = columns.BooleanColumn()
    status = tables.Column()
    user = tables.Column()

    class Meta(StatusPageTable.Meta):
        model = IncidentUpdate
        fields = ('pk', 'id', 'text', 'new_status', 'status', 'user', 'created', 'last_updated')
        default_columns = ('id', 'text', 'new_status', 'status', 'user')
