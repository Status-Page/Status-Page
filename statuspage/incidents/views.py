from django.core.handlers.wsgi import WSGIRequest
from django.db.models import Q

from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from .models import Incident, IncidentUpdate, IncidentTemplate
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


class IncidentCreateView(generic.ObjectEditView):
    queryset = Incident.objects.filter()
    form = forms.IncidentForm
    template_name = 'incidents/incident_create.html'

    def get_extra_context(self, request, instance: Incident):
        template_form = forms.IncidentTemplateSelectForm(initial={
            'template': request.GET.get('template', None)
        })

        selected_template_id = request.GET.get('template', None)
        if selected_template_id:
            selected_template = IncidentTemplate.objects.get(pk=selected_template_id)
            form = forms.IncidentForm(instance=instance, initial={
                'title': selected_template.title,
                'status': selected_template.status,
                'impact': selected_template.impact,
                'visibility': selected_template.visibility,
                'components': selected_template.components.all(),
                'update_component_status': selected_template.update_component_status,
                'text': selected_template.text,
            })
            return {
                'form': form,
                'template_form': template_form,
            }

        return {
            'template_form': template_form,
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


class IncidentTemplateListView(generic.ObjectListView):
    queryset = IncidentTemplate.objects.filter()
    table = tables.IncidentTemplateTable
    filterset = filtersets.IncidentTemplateFilterSet
    filterset_form = forms.IncidentTemplateFilterForm


class IncidentTemplateView(generic.ObjectView, ActionsMixin):
    queryset = IncidentTemplate.objects.filter()


class IncidentTemplateEditView(generic.ObjectEditView):
    queryset = IncidentTemplate.objects.filter()
    form = forms.IncidentTemplateForm


class IncidentTemplateDeleteView(generic.ObjectDeleteView):
    queryset = IncidentTemplate.objects.filter()


class IncidentTemplateBulkEditView(generic.BulkEditView):
    queryset = IncidentTemplate.objects.all()
    table = tables.IncidentTemplateTable
    form = forms.IncidentTemplateBulkEditForm


class IncidentTemplateBulkDeleteView(generic.BulkDeleteView):
    queryset = IncidentTemplate.objects.all()
    table = tables.IncidentTemplateTable
