from django.contrib import messages
from django.contrib.auth.mixins import LoginRequiredMixin, PermissionRequiredMixin
from django.shortcuts import redirect, render, get_object_or_404
from django.urls import reverse
from django.views import View

from statuspage.views import generic
from utilities.forms import ConfirmationForm
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


class MetricPointsDeleteView(LoginRequiredMixin, PermissionRequiredMixin, View):
    permission_required = (
        'metrics.delete_metricpoint'
    )

    def get(self, request, pk):
        metric = get_object_or_404(Metric.objects.all(), pk=pk)
        initial_data = {
            'return_url': reverse('metrics:metric', kwargs={'pk': pk}),
        }
        form = ConfirmationForm(initial=initial_data)

        return render(request, 'generic/object_delete.html', {
            'object': metric,
            'form': form,
            'return_url': reverse('metrics:metric', kwargs={'pk': pk}),
        })

    def post(self, request, pk):
        metric = get_object_or_404(Metric.objects.all(), pk=pk)
        form = ConfirmationForm(request.POST)
        if form.is_valid():
            metric.points.all().delete()
            messages.success(request, "Metric Points deleted")
            return redirect('metrics:metric', pk=pk)

        return render(request, 'generic/object_delete.html', {
            'object': metric,
            'form': form,
            'return_url': reverse('metrics:metric', kwargs={'pk': pk}),
        })
