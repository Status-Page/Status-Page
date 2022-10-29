from statuspage.views import generic
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


class ComponentGroupView(generic.ObjectView):
    queryset = ComponentGroup.objects.all()


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
