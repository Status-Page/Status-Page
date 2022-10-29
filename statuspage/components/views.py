from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from .models import Component, ComponentGroup
from . import tables
from . import forms
from . import filtersets


class ComponentListView(generic.ObjectListView):
    queryset = Component.objects.all()
    table = tables.ComponentTable
    filterset = filtersets.ComponentFilterSet
    filterset_form = forms.ComponentFilterForm


class ComponentView(generic.ObjectView):
    queryset = Component.objects.all()


class ComponentEditView(generic.ObjectEditView):
    queryset = Component.objects.all()
    form = forms.ComponentForm


class ComponentDeleteView(generic.ObjectDeleteView):
    queryset = Component.objects.all()


class ComponentBulkEditView(generic.BulkEditView):
    queryset = Component.objects.all()
    table = tables.ComponentTable
    form = forms.ComponentBulkEditForm


class ComponentBulkDeleteView(generic.BulkDeleteView):
    queryset = Component.objects.all()
    table = tables.ComponentTable


class ComponentGroupListView(generic.ObjectListView):
    queryset = ComponentGroup.objects.all()
    table = tables.ComponentGroupTable
    filterset = filtersets.ComponentGroupFilterSet
    filterset_form = forms.ComponentGroupFilterForm


class ComponentGroupView(generic.ObjectView, ActionsMixin):
    queryset = ComponentGroup.objects.all()

    def get_extra_context(self, request, instance):
        queryset = instance.components.all()

        actions = self.get_permitted_actions(request.user)
        has_bulk_actions = any([a.startswith('bulk_') for a in actions])

        table = tables.ComponentTable(queryset)
        if 'pk' in table.base_columns and has_bulk_actions:
            table.columns.show('pk')
        table.configure(request)

        return {
            'model': queryset.model,
            'table': table,
            'actions': actions,
        }


class ComponentGroupEditView(generic.ObjectEditView):
    queryset = ComponentGroup.objects.all()
    form = forms.ComponentGroupForm


class ComponentGroupDeleteView(generic.ObjectDeleteView):
    queryset = ComponentGroup.objects.all()


class ComponentGroupBulkEditView(generic.BulkEditView):
    queryset = ComponentGroup.objects.all()
    table = tables.ComponentGroupTable
    form = forms.ComponentGroupBulkEditForm


class ComponentGroupBulkDeleteView(generic.BulkDeleteView):
    queryset = ComponentGroup.objects.all()
    table = tables.ComponentGroupTable
