from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from utilities.views import register_model_view
from .models import ExternalStatusPage, ExternalStatusComponent
from . import tables
from . import forms
from . import filtersets


@register_model_view(ExternalStatusPage, 'list')
class ExternalStatusPageListView(generic.ObjectListView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable
    filterset = filtersets.ExternalStatusPageFilterSet
    filterset_form = forms.ExternalStatusPageFilterForm


@register_model_view(ExternalStatusPage)
class ExternalStatusPageView(generic.ObjectView, ActionsMixin):
    queryset = ExternalStatusPage.objects.all()

    def get_extra_context(self, request, instance):
        queryset = instance.components.all()

        actions = self.get_permitted_actions(request.user)
        has_bulk_actions = any([a.startswith('bulk_') for a in actions])

        table = tables.ExternalStatusComponentTable(queryset)
        if 'pk' in table.base_columns and has_bulk_actions:
            table.columns.show('pk')
        table.configure(request)

        return {
            'model': queryset.model,
            'table': table,
            'actions': actions,
        }


@register_model_view(ExternalStatusPage, 'edit')
@register_model_view(ExternalStatusPage, 'add')
class ExternalStatusPageEditView(generic.ObjectEditView):
    queryset = ExternalStatusPage.objects.all()
    form = forms.ExternalStatusPageForm


@register_model_view(ExternalStatusPage, 'delete')
class ExternalStatusPageDeleteView(generic.ObjectDeleteView):
    queryset = ExternalStatusPage.objects.all()


@register_model_view(ExternalStatusPage, 'bulk_edit')
class ExternalStatusPageBulkEditView(generic.BulkEditView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable
    form = forms.ExternalStatusPageBulkEditForm


@register_model_view(ExternalStatusPage, 'bulk_delete')
class ExternalStatusPageBulkDeleteView(generic.BulkDeleteView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable


@register_model_view(ExternalStatusComponent, 'list')
class ExternalStatusComponentListView(generic.ObjectListView):
    queryset = ExternalStatusComponent.objects.all()
    table = tables.ExternalStatusComponentTable
    filterset = filtersets.ExternalStatusComponentFilterSet
    filterset_form = forms.ExternalStatusComponentFilterForm


@register_model_view(ExternalStatusComponent)
class ExternalStatusComponentView(generic.ObjectView):
    queryset = ExternalStatusComponent.objects.all()


@register_model_view(ExternalStatusComponent, 'edit')
@register_model_view(ExternalStatusComponent, 'add')
class ExternalStatusComponentEditView(generic.ObjectEditView):
    queryset = ExternalStatusComponent.objects.all()
    form = forms.ExternalStatusComponentForm


@register_model_view(ExternalStatusComponent, 'delete')
class ExternalStatusComponentDeleteView(generic.ObjectDeleteView):
    queryset = ExternalStatusComponent.objects.all()


@register_model_view(ExternalStatusComponent, 'bulk_edit')
class ExternalStatusComponentBulkEditView(generic.BulkEditView):
    queryset = ExternalStatusComponent.objects.all()
    table = tables.ExternalStatusComponentTable
    form = forms.ExternalStatusComponentBulkEditForm


@register_model_view(ExternalStatusComponent, 'bulk_delete')
class ExternalStatusComponentBulkDeleteView(generic.BulkDeleteView):
    queryset = ExternalStatusComponent.objects.all()
    table = tables.ExternalStatusComponentTable
