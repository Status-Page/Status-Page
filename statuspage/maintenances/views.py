from django.db.models import Q

from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from .models import Maintenance, MaintenanceUpdate, MaintenanceTemplate
from . import tables
from . import forms
from . import filtersets
from .choices import MaintenanceStatusChoices


class MaintenanceListView(generic.ObjectListView):
    queryset = Maintenance.objects.filter(~Q(status=MaintenanceStatusChoices.COMPLETED))
    table = tables.MaintenanceTable
    filterset = filtersets.MaintenanceFilterSet
    filterset_form = forms.MaintenanceFilterForm


class MaintenanceView(generic.ObjectView, ActionsMixin):
    queryset = Maintenance.objects.filter()

    def get_extra_context(self, request, instance):
        queryset = instance.updates.all()

        actions = self.get_permitted_actions(request.user)
        has_bulk_actions = any([a.startswith('bulk_') for a in actions])

        table = tables.MaintenanceUpdateTable(queryset)
        if 'pk' in table.base_columns and has_bulk_actions:
            table.columns.show('pk')
        table.configure(request)

        return {
            'model': queryset.model,
            'table': table,
            'actions': actions,
        }


class MaintenanceCreateView(generic.ObjectEditView):
    queryset = Maintenance.objects.filter()
    form = forms.MaintenanceForm
    template_name = 'maintenances/maintenance_edit.html'

    def get_extra_context(self, request, instance: Maintenance):
        template_form = forms.MaintenanceTemplateSelectForm(initial={
            'template': request.GET.get('template', None)
        })

        selected_template_id = request.GET.get('template', None)
        if selected_template_id:
            selected_template = MaintenanceTemplate.objects.get(pk=selected_template_id)
            form = forms.MaintenanceForm(instance=instance, initial={
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


class MaintenanceEditView(generic.ObjectEditView):
    queryset = Maintenance.objects.filter()
    form = forms.MaintenanceForm
    template_name = 'maintenances/maintenance_edit.html'

    def get_extra_context(self, request, instance: Maintenance):
        template_form = forms.MaintenanceTemplateSelectForm(initial={
            'template': request.GET.get('template', None)
        })

        selected_template_id = request.GET.get('template', None)
        if selected_template_id:
            selected_template = MaintenanceTemplate.objects.get(pk=selected_template_id)
            form = forms.MaintenanceForm(instance=instance, initial={
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


class MaintenanceDeleteView(generic.ObjectDeleteView):
    queryset = Maintenance.objects.filter()


class MaintenanceBulkEditView(generic.BulkEditView):
    queryset = Maintenance.objects.all()
    table = tables.MaintenanceTable
    form = forms.MaintenanceBulkEditForm


class MaintenanceBulkDeleteView(generic.BulkDeleteView):
    queryset = Maintenance.objects.all()
    table = tables.MaintenanceTable


class PastMaintenanceListView(generic.ObjectListView):
    queryset = Maintenance.objects.filter(status=MaintenanceStatusChoices.COMPLETED)
    table = tables.MaintenanceTable
    filterset = filtersets.MaintenanceFilterSet
    filterset_form = forms.MaintenanceFilterForm


class MaintenanceUpdateView(generic.ObjectView):
    queryset = MaintenanceUpdate.objects.filter()


class MaintenanceUpdateEditView(generic.ObjectEditView):
    queryset = MaintenanceUpdate.objects.filter()
    form = forms.MaintenanceUpdateForm


class MaintenanceUpdateDeleteView(generic.ObjectDeleteView):
    queryset = MaintenanceUpdate.objects.filter()


class MaintenanceUpdateBulkEditView(generic.BulkEditView):
    queryset = MaintenanceUpdate.objects.all()
    table = tables.MaintenanceUpdateTable
    form = forms.MaintenanceUpdateBulkEditForm


class MaintenanceUpdateBulkDeleteView(generic.BulkDeleteView):
    queryset = MaintenanceUpdate.objects.all()
    table = tables.MaintenanceUpdateTable


class MaintenanceTemplateListView(generic.ObjectListView):
    queryset = MaintenanceTemplate.objects.filter()
    table = tables.MaintenanceTemplateTable
    filterset = filtersets.MaintenanceTemplateFilterSet
    filterset_form = forms.MaintenanceTemplateFilterForm


class MaintenanceTemplateView(generic.ObjectView, ActionsMixin):
    queryset = MaintenanceTemplate.objects.filter()


class MaintenanceTemplateEditView(generic.ObjectEditView):
    queryset = MaintenanceTemplate.objects.filter()
    form = forms.MaintenanceTemplateForm


class MaintenanceTemplateDeleteView(generic.ObjectDeleteView):
    queryset = MaintenanceTemplate.objects.filter()


class MaintenanceTemplateBulkEditView(generic.BulkEditView):
    queryset = MaintenanceTemplate.objects.all()
    table = tables.MaintenanceTemplateTable
    form = forms.MaintenanceTemplateBulkEditForm


class MaintenanceTemplateBulkDeleteView(generic.BulkDeleteView):
    queryset = MaintenanceTemplate.objects.all()
    table = tables.MaintenanceTemplateTable
