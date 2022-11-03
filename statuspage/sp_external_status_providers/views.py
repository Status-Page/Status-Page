from statuspage.views import generic
from .models import ExternalStatusPage, ExternalStatusComponent
from . import tables
from . import forms
from . import filtersets


class ExternalStatusPageListView(generic.ObjectListView):
    queryset = ExternalStatusPage.objects.all()
    table = tables.ExternalStatusPageTable
    filterset = filtersets.ExternalStatusPageFilterSet
    filterset_form = forms.ExternalStatusPageFilterForm


class ExternalStatusPageView(generic.ObjectView):
    queryset = ExternalStatusPage.objects.all()


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
