import django_tables2 as tables

from statuspage.tables import StatusPageTable, columns
from .models import Component, ComponentGroup


class ComponentTable(StatusPageTable):
    name = tables.Column(
        linkify=True,
    )
    component_group = tables.Column(
        verbose_name='Component Group'
    )
    status = columns.ChoiceFieldColumn()
    visibility = columns.BooleanColumn()

    class Meta(StatusPageTable.Meta):
        model = Component
        fields = ('pk', 'id', 'name', 'component_group', 'status', 'visibility', 'order', 'created', 'last_updated')
        default_columns = ('id', 'name', 'component_group', 'status', 'visibility', 'order')


class ComponentGroupTable(StatusPageTable):
    name = tables.Column(
        linkify=True,
    )
    visibility = columns.BooleanColumn()

    class Meta(StatusPageTable.Meta):
        model = ComponentGroup
        fields = ('pk', 'id', 'name', 'visibility', 'order', 'collapse', 'created', 'last_updated')
        default_columns = ('id', 'name', 'visibility', 'order', 'collapse')
