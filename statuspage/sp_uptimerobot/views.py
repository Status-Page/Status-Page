from statuspage.views import generic
from utilities.views import register_global_model_view, register_model_view
from .models import UptimeRobotMonitor
from . import tables
from . import forms
from . import filtersets


@register_global_model_view(UptimeRobotMonitor, 'list')
class UptimeRobotMonitorListView(generic.ObjectListView):
    queryset = UptimeRobotMonitor.objects.all()
    table = tables.UptimeRobotMonitorTable
    filterset = filtersets.UptimeRobotMonitorFilterSet
    filterset_form = forms.UptimeRobotMonitorFilterForm


@register_model_view(UptimeRobotMonitor)
class UptimeRobotMonitorView(generic.ObjectView):
    queryset = UptimeRobotMonitor.objects.all()


@register_model_view(UptimeRobotMonitor, 'edit')
class UptimeRobotMonitorEditView(generic.ObjectEditView):
    queryset = UptimeRobotMonitor.objects.all()
    form = forms.UptimeRobotMonitorForm


@register_model_view(UptimeRobotMonitor, 'delete')
class UptimeRobotMonitorDeleteView(generic.ObjectDeleteView):
    queryset = UptimeRobotMonitor.objects.all()


@register_global_model_view(UptimeRobotMonitor, 'bulk_edit')
class UptimeRobotMonitorBulkEditView(generic.BulkEditView):
    queryset = UptimeRobotMonitor.objects.all()
    table = tables.UptimeRobotMonitorTable
    form = forms.UptimeRobotMonitorBulkEditForm


@register_global_model_view(UptimeRobotMonitor, 'bulk_delete')
class UptimeRobotMonitorBulkDeleteView(generic.BulkDeleteView):
    queryset = UptimeRobotMonitor.objects.all()
    table = tables.UptimeRobotMonitorTable
