from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import UptimeRobotMonitor

urlpatterns = [
    path('', views.UptimeRobotMonitorListView.as_view(), name='uptimerobotmonitor_list'),
    path('edit/', views.UptimeRobotMonitorBulkEditView.as_view(), name='uptimerobotmonitor_bulk_edit'),
    path('delete/', views.UptimeRobotMonitorBulkDeleteView.as_view(), name='uptimerobotmonitor_bulk_delete'),
    path('<int:pk>/', views.UptimeRobotMonitorView.as_view(), name='uptimerobotmonitor'),
    path('<int:pk>/edit/', views.UptimeRobotMonitorEditView.as_view(), name='uptimerobotmonitor_edit'),
    path('<int:pk>/delete/', views.UptimeRobotMonitorDeleteView.as_view(), name='uptimerobotmonitor_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='uptimerobotmonitor_changelog', kwargs={
        'model': UptimeRobotMonitor,
    }),
]
