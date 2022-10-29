from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import Metric

app_name = 'metrics'
urlpatterns = [
    path('', views.MetricListView.as_view(), name='metric_list'),
    path('add/', views.MetricEditView.as_view(), name='metric_add'),
    path('edit/', views.MetricBulkEditView.as_view(), name='metric_bulk_edit'),
    path('delete/', views.MetricBulkDeleteView.as_view(), name='metric_bulk_delete'),
    path('<int:pk>/', views.MetricView.as_view(), name='metric'),
    path('<int:pk>/edit/', views.MetricEditView.as_view(), name='metric_edit'),
    path('<int:pk>/delete/', views.MetricDeleteView.as_view(), name='metric_delete'),
    path('<int:pk>/metric-points/delete/', views.MetricPointsDeleteView.as_view(), name='metricpoints_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='metric_changelog', kwargs={
        'model': Metric,
    }),
]
