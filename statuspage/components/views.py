from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from utilities.views import register_model_view
from .models import Component, ComponentGroup
from . import tables
from . import forms
from . import filtersets


@register_model_view(Component, 'list')
class ComponentListView(generic.ObjectListView):
    queryset = Component.objects.all()
    table = tables.ComponentTable
    filterset = filtersets.ComponentFilterSet
    filterset_form = forms.ComponentFilterForm


@register_model_view(Component)
@register_model_view(Component, 'add')
class ComponentView(generic.ObjectView):
    queryset = Component.objects.all()


@register_model_view(Component, 'edit')
class ComponentEditView(generic.ObjectEditView):
    queryset = Component.objects.all()
    form = forms.ComponentForm


@register_model_view(Component, 'delete')
class ComponentDeleteView(generic.ObjectDeleteView):
    queryset = Component.objects.all()


@register_model_view(Component, 'bulk_edit')
class ComponentBulkEditView(generic.BulkEditView):
    queryset = Component.objects.all()
    table = tables.ComponentTable
    form = forms.ComponentBulkEditForm


@register_model_view(Component, 'bulk_delete')
class ComponentBulkDeleteView(generic.BulkDeleteView):
    queryset = Component.objects.all()
    table = tables.ComponentTable


@register_model_view(ComponentGroup, 'list')
class ComponentGroupListView(generic.ObjectListView):
    queryset = ComponentGroup.objects.all()
    table = tables.ComponentGroupTable
    filterset = filtersets.ComponentGroupFilterSet
    filterset_form = forms.ComponentGroupFilterForm


@register_model_view(ComponentGroup)
@register_model_view(ComponentGroup, 'add')
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


@register_model_view(ComponentGroup, 'edit')
class ComponentGroupEditView(generic.ObjectEditView):
    queryset = ComponentGroup.objects.all()
    form = forms.ComponentGroupForm


@register_model_view(ComponentGroup, 'delete')
class ComponentGroupDeleteView(generic.ObjectDeleteView):
    queryset = ComponentGroup.objects.all()


@register_model_view(ComponentGroup, 'bulk_edit')
class ComponentGroupBulkEditView(generic.BulkEditView):
    queryset = ComponentGroup.objects.all()
    table = tables.ComponentGroupTable
    form = forms.ComponentGroupBulkEditForm


@register_model_view(ComponentGroup, 'bulk_delete')
class ComponentGroupBulkDeleteView(generic.BulkDeleteView):
    queryset = ComponentGroup.objects.all()
    table = tables.ComponentGroupTable
