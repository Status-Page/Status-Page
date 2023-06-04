from django.db.models import Q

from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from utilities.views import register_global_model_view, register_model_view, ViewTab
from .models import Maintenance, MaintenanceUpdate, MaintenanceTemplate
from . import tables
from . import forms
from . import filtersets
from .choices import MaintenanceStatusChoices


@register_global_model_view(Maintenance, 'list')
class MaintenanceListView(generic.ObjectListView):
    queryset = Maintenance.objects.filter(~Q(status=MaintenanceStatusChoices.COMPLETED))
    table = tables.MaintenanceTable
    filterset = filtersets.MaintenanceFilterSet
    filterset_form = forms.MaintenanceFilterForm


@register_model_view(Maintenance)
class MaintenanceView(generic.ObjectView, ActionsMixin):
    queryset = Maintenance.objects.filter()


@register_model_view(Maintenance, 'updates')
class IncidentIncidentUpdateListView(generic.ObjectChildrenView):
    queryset = Maintenance.objects.all()
    child_model = MaintenanceUpdate
    table = tables.MaintenanceUpdateTable
    tab = ViewTab(
        label='Maintenance Updates',
        badge=lambda x: x.updates.count(),
        permission='maintenances.view_maintenanceupdate',
        weight=500,
    )
    template_name = 'maintenances/maintenance/maintenanceupdates.html'

    def get_children(self, request, parent):
        return parent.updates.restrict(request.user, 'view').all()


@register_global_model_view(Maintenance, 'add')
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


@register_model_view(Maintenance, 'edit')
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


@register_model_view(Maintenance, 'delete')
class MaintenanceDeleteView(generic.ObjectDeleteView):
    queryset = Maintenance.objects.filter()


@register_global_model_view(Maintenance, 'bulk_edit')
class MaintenanceBulkEditView(generic.BulkEditView):
    queryset = Maintenance.objects.all()
    table = tables.MaintenanceTable
    form = forms.MaintenanceBulkEditForm


@register_global_model_view(Maintenance, 'bulk_delete')
class MaintenanceBulkDeleteView(generic.BulkDeleteView):
    queryset = Maintenance.objects.all()
    table = tables.MaintenanceTable


@register_global_model_view(Maintenance, 'past')
class PastMaintenanceListView(generic.ObjectListView):
    queryset = Maintenance.objects.filter(status=MaintenanceStatusChoices.COMPLETED)
    table = tables.MaintenanceTable
    filterset = filtersets.MaintenanceFilterSet
    filterset_form = forms.MaintenanceFilterForm


@register_model_view(MaintenanceUpdate)
class MaintenanceUpdateView(generic.ObjectView):
    queryset = MaintenanceUpdate.objects.filter()


@register_model_view(MaintenanceUpdate, 'edit')
class MaintenanceUpdateEditView(generic.ObjectEditView):
    queryset = MaintenanceUpdate.objects.filter()
    form = forms.MaintenanceUpdateForm


@register_model_view(MaintenanceUpdate, 'delete')
class MaintenanceUpdateDeleteView(generic.ObjectDeleteView):
    queryset = MaintenanceUpdate.objects.filter()


@register_global_model_view(MaintenanceUpdate, 'bulk_edit')
class MaintenanceUpdateBulkEditView(generic.BulkEditView):
    queryset = MaintenanceUpdate.objects.all()
    table = tables.MaintenanceUpdateTable
    form = forms.MaintenanceUpdateBulkEditForm


@register_global_model_view(MaintenanceUpdate, 'bulk_delete')
class MaintenanceUpdateBulkDeleteView(generic.BulkDeleteView):
    queryset = MaintenanceUpdate.objects.all()
    table = tables.MaintenanceUpdateTable


@register_global_model_view(MaintenanceTemplate, 'list')
class MaintenanceTemplateListView(generic.ObjectListView):
    queryset = MaintenanceTemplate.objects.filter()
    table = tables.MaintenanceTemplateTable
    filterset = filtersets.MaintenanceTemplateFilterSet
    filterset_form = forms.MaintenanceTemplateFilterForm


@register_model_view(MaintenanceTemplate)
@register_global_model_view(MaintenanceTemplate, 'add')
class MaintenanceTemplateView(generic.ObjectView, ActionsMixin):
    queryset = MaintenanceTemplate.objects.filter()


@register_model_view(MaintenanceTemplate, 'edit')
class MaintenanceTemplateEditView(generic.ObjectEditView):
    queryset = MaintenanceTemplate.objects.filter()
    form = forms.MaintenanceTemplateForm


@register_model_view(MaintenanceTemplate, 'delete')
class MaintenanceTemplateDeleteView(generic.ObjectDeleteView):
    queryset = MaintenanceTemplate.objects.filter()


@register_global_model_view(MaintenanceTemplate, 'bulk_edit')
class MaintenanceTemplateBulkEditView(generic.BulkEditView):
    queryset = MaintenanceTemplate.objects.all()
    table = tables.MaintenanceTemplateTable
    form = forms.MaintenanceTemplateBulkEditForm


@register_global_model_view(MaintenanceTemplate, 'bulk_delete')
class MaintenanceTemplateBulkDeleteView(generic.BulkDeleteView):
    queryset = MaintenanceTemplate.objects.all()
    table = tables.MaintenanceTemplateTable
