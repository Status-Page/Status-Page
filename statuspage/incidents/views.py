from django.db.models import Q

from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from .models import Incident, IncidentUpdate
from . import tables
from . import forms
from . import filtersets
from .choices import IncidentStatusChoices


class IncidentListView(generic.ObjectListView):
    queryset = Incident.objects.filter(~Q(status=IncidentStatusChoices.RESOLVED))
    table = tables.IncidentTable
    filterset = filtersets.IncidentFilterSet
    filterset_form = forms.IncidentFilterForm


class IncidentView(generic.ObjectView, ActionsMixin):
    queryset = Incident.objects.filter()

    def get_extra_context(self, request, instance):
        queryset = instance.updates.all()

        actions = self.get_permitted_actions(request.user)
        has_bulk_actions = any([a.startswith('bulk_') for a in actions])

        table = tables.IncidentUpdateTable(queryset)
        if 'pk' in table.base_columns and has_bulk_actions:
            table.columns.show('pk')
        table.configure(request)

        return {
            'model': queryset.model,
            'table': table,
            'actions': actions,
        }


class IncidentEditView(generic.ObjectEditView):
    queryset = Incident.objects.filter()
    form = forms.IncidentForm


class IncidentDeleteView(generic.ObjectDeleteView):
    queryset = Incident.objects.filter()


class IncidentBulkEditView(generic.BulkEditView):
    queryset = Incident.objects.all()
    table = tables.IncidentTable
    form = forms.IncidentBulkEditForm


class IncidentBulkDeleteView(generic.BulkDeleteView):
    queryset = Incident.objects.all()
    table = tables.IncidentTable


class PastIncidentListView(generic.ObjectListView):
    queryset = Incident.objects.filter(status=IncidentStatusChoices.RESOLVED)
    table = tables.IncidentTable
    filterset = filtersets.IncidentFilterSet
    filterset_form = forms.IncidentFilterForm


class IncidentUpdateView(generic.ObjectView):
    queryset = IncidentUpdate.objects.filter()


class IncidentUpdateEditView(generic.ObjectEditView):
    queryset = IncidentUpdate.objects.filter()
    form = forms.IncidentUpdateForm


class IncidentUpdateDeleteView(generic.ObjectDeleteView):
    queryset = IncidentUpdate.objects.filter()


class IncidentUpdateBulkEditView(generic.BulkEditView):
    queryset = IncidentUpdate.objects.all()
    table = tables.IncidentUpdateTable
    form = forms.IncidentUpdateBulkEditForm


class IncidentUpdateBulkDeleteView(generic.BulkDeleteView):
    queryset = IncidentUpdate.objects.all()
    table = tables.IncidentUpdateTable
