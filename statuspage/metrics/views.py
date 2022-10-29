from statuspage.views import generic
from .models import Metric
from . import tables
from . import forms
from . import filtersets


class MetricListView(generic.ObjectListView):
    queryset = Metric.objects.all()
    table = tables.MetricTable
    filterset = filtersets.MetricFilterSet
    filterset_form = forms.MetricFilterForm


class MetricView(generic.ObjectView):
    queryset = Metric.objects.all()


class MetricEditView(generic.ObjectEditView):
    queryset = Metric.objects.all()
    form = forms.MetricForm


class MetricDeleteView(generic.ObjectDeleteView):
    queryset = Metric.objects.all()


class MetricBulkEditView(generic.BulkEditView):
    queryset = Metric.objects.all()
    table = tables.MetricTable
    form = forms.MetricBulkEditForm


class MetricBulkDeleteView(generic.BulkDeleteView):
    queryset = Metric.objects.all()
    table = tables.MetricTable
