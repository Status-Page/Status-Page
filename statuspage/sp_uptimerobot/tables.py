import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns
from .models import UptimeRobotMonitor


class UptimeRobotMonitorTable(StatusPageTable):
    friendly_name = tables.Column(
        linkify=True,
        verbose_name='Name',
    )
    status = columns.ChoiceFieldColumn()
    paused = columns.BooleanColumn()

    class Meta(StatusPageTable.Meta):
        model = UptimeRobotMonitor
        fields = ('pk', 'id', 'friendly_name', 'monitor_id', 'status', 'component', 'metric', 'paused')
        default_columns = ('pk', 'friendly_name', 'status', 'component', 'metric', 'paused')
