from statuspage.views import generic
from .models import UptimeRobotMonitor
from . import tables
from . import forms
from . import filtersets


class UptimeRobotMonitorListView(generic.ObjectListView):
    queryset = UptimeRobotMonitor.objects.all()
    table = tables.UptimeRobotMonitorTable
    filterset = filtersets.UptimeRobotMonitorFilterSet
    filterset_form = forms.UptimeRobotMonitorFilterForm


class UptimeRobotMonitorView(generic.ObjectView):
    queryset = UptimeRobotMonitor.objects.all()


class UptimeRobotMonitorEditView(generic.ObjectEditView):
    queryset = UptimeRobotMonitor.objects.all()
    form = forms.UptimeRobotMonitorForm


class UptimeRobotMonitorDeleteView(generic.ObjectDeleteView):
    queryset = UptimeRobotMonitor.objects.all()


class UptimeRobotMonitorBulkEditView(generic.BulkEditView):
    queryset = UptimeRobotMonitor.objects.all()
    table = tables.UptimeRobotMonitorTable
    form = forms.UptimeRobotMonitorBulkEditForm


class UptimeRobotMonitorBulkDeleteView(generic.BulkDeleteView):
    queryset = UptimeRobotMonitor.objects.all()
    table = tables.UptimeRobotMonitorTable
