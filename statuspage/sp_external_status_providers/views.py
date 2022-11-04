from statuspage.views import generic
from statuspage.views.generic.mixins import ActionsMixin
from .models import ExternalStatusPage, ExternalStatusComponent
from . import tables
from . import forms
from . import filtersets


class ExternalStatusPageListView(generic.ObjectListView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable
    filterset = filtersets.ExternalStatusPageFilterSet
    filterset_form = forms.ExternalStatusPageFilterForm


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


class ExternalStatusPageEditView(generic.ObjectEditView):
    queryset = ExternalStatusPage.objects.all()
    form = forms.ExternalStatusPageForm


class ExternalStatusPageDeleteView(generic.ObjectDeleteView):
    queryset = ExternalStatusPage.objects.all()


class ExternalStatusPageBulkEditView(generic.BulkEditView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable
    form = forms.ExternalStatusPageBulkEditForm


class ExternalStatusPageBulkDeleteView(generic.BulkDeleteView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable


class ExternalStatusComponentListView(generic.ObjectListView):
    queryset = ExternalStatusComponent.objects.all()
    table = tables.ExternalStatusComponentTable
    filterset = filtersets.ExternalStatusComponentFilterSet
    filterset_form = forms.ExternalStatusComponentFilterForm


class ExternalStatusComponentView(generic.ObjectView):
    queryset = ExternalStatusComponent.objects.all()


class ExternalStatusComponentEditView(generic.ObjectEditView):
    queryset = ExternalStatusComponent.objects.all()
    form = forms.ExternalStatusComponentForm


class ExternalStatusComponentDeleteView(generic.ObjectDeleteView):
    queryset = ExternalStatusComponent.objects.all()


class ExternalStatusComponentBulkEditView(generic.BulkEditView):
    queryset = ExternalStatusComponent.objects.all()
    table = tables.ExternalStatusComponentTable
    form = forms.ExternalStatusComponentBulkEditForm


class ExternalStatusComponentBulkDeleteView(generic.BulkDeleteView):
    queryset = ExternalStatusComponent.objects.all()
    table = tables.ExternalStatusComponentTable
