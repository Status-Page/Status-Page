import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns
from .models import Subscriber


class SubscriberTable(StatusPageTable):
    email = tables.Column(
        linkify=True,
    )
    actions = columns.ActionsColumn(
        actions=('delete', 'changelog')
    )
    incident_subscriptions = columns.BooleanColumn()

    class Meta(StatusPageTable.Meta):
        model = Subscriber
        fields = ('pk', 'id', 'email', 'email_verified_at', 'incident_subscriptions', 'created', 'last_updated')
        default_columns = ('id', 'email', 'email_verified_at')
