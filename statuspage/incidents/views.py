from django.db.models import Q

from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from utilities.views import register_global_model_view, register_model_view
from .models import Incident, IncidentUpdate, IncidentTemplate
from . import tables
from . import forms
from . import filtersets
from .choices import IncidentStatusChoices


@register_global_model_view(Incident, 'list')
class IncidentListView(generic.ObjectListView):
    queryset = Incident.objects.filter(~Q(status=IncidentStatusChoices.RESOLVED))
    table = tables.IncidentTable
    filterset = filtersets.IncidentFilterSet
    filterset_form = forms.IncidentFilterForm


@register_model_view(Incident)
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


@register_global_model_view(Incident, 'add')
class IncidentCreateView(generic.ObjectEditView):
    queryset = Incident.objects.filter()
    form = forms.IncidentForm
    template_name = 'incidents/incident_edit.html'

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


@register_model_view(Incident, 'edit')
class IncidentEditView(generic.ObjectEditView):
    queryset = Incident.objects.filter()
    form = forms.IncidentForm
    template_name = 'incidents/incident_edit.html'

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


@register_model_view(Incident, 'delete')
class IncidentDeleteView(generic.ObjectDeleteView):
    queryset = Incident.objects.filter()


@register_global_model_view(Incident, 'bulk_edit')
class IncidentBulkEditView(generic.BulkEditView):
    queryset = Incident.objects.all()
    table = tables.IncidentTable
    form = forms.IncidentBulkEditForm


@register_global_model_view(Incident, 'bulk_delete')
class IncidentBulkDeleteView(generic.BulkDeleteView):
    queryset = Incident.objects.all()
    table = tables.IncidentTable


@register_global_model_view(Incident, 'past')
class PastIncidentListView(generic.ObjectListView):
    queryset = Incident.objects.filter(status=IncidentStatusChoices.RESOLVED)
    table = tables.IncidentTable
    filterset = filtersets.IncidentFilterSet
    filterset_form = forms.IncidentFilterForm


@register_model_view(IncidentUpdate)
class IncidentUpdateView(generic.ObjectView):
    queryset = IncidentUpdate.objects.filter()


@register_model_view(IncidentUpdate, 'edit')
class IncidentUpdateEditView(generic.ObjectEditView):
    queryset = IncidentUpdate.objects.filter()
    form = forms.IncidentUpdateForm


@register_model_view(IncidentUpdate, 'delete')
class IncidentUpdateDeleteView(generic.ObjectDeleteView):
    queryset = IncidentUpdate.objects.filter()


@register_global_model_view(IncidentUpdate, 'bulk_edit')
class IncidentUpdateBulkEditView(generic.BulkEditView):
    queryset = IncidentUpdate.objects.all()
    table = tables.IncidentUpdateTable
    form = forms.IncidentUpdateBulkEditForm


@register_global_model_view(IncidentUpdate, 'bulk_delete')
class IncidentUpdateBulkDeleteView(generic.BulkDeleteView):
    queryset = IncidentUpdate.objects.all()
    table = tables.IncidentUpdateTable


@register_global_model_view(IncidentTemplate, 'list')
class IncidentTemplateListView(generic.ObjectListView):
    queryset = IncidentTemplate.objects.filter()
    table = tables.IncidentTemplateTable
    filterset = filtersets.IncidentTemplateFilterSet
    filterset_form = forms.IncidentTemplateFilterForm


@register_model_view(IncidentTemplate)
class IncidentTemplateView(generic.ObjectView, ActionsMixin):
    queryset = IncidentTemplate.objects.filter()


@register_model_view(IncidentTemplate, 'edit')
class IncidentTemplateEditView(generic.ObjectEditView):
    queryset = IncidentTemplate.objects.filter()
    form = forms.IncidentTemplateForm


@register_model_view(IncidentTemplate, 'delete')
class IncidentTemplateDeleteView(generic.ObjectDeleteView):
    queryset = IncidentTemplate.objects.filter()


@register_global_model_view(IncidentTemplate, 'bulk_edit')
class IncidentTemplateBulkEditView(generic.BulkEditView):
    queryset = IncidentTemplate.objects.all()
    table = tables.IncidentTemplateTable
    form = forms.IncidentTemplateBulkEditForm


@register_global_model_view(IncidentTemplate, 'bulk_delete')
class IncidentTemplateBulkDeleteView(generic.BulkDeleteView):
    queryset = IncidentTemplate.objects.all()
    table = tables.IncidentTemplateTable
