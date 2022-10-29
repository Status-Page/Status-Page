from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import Maintenance, MaintenanceUpdate

app_name = 'maintenances'
urlpatterns = [
    path('', views.MaintenanceListView.as_view(), name='maintenance_list'),
    path('add/', views.MaintenanceEditView.as_view(), name='maintenance_add'),
    path('edit/', views.MaintenanceBulkEditView.as_view(), name='maintenance_bulk_edit'),
    path('delete/', views.MaintenanceBulkDeleteView.as_view(), name='maintenance_bulk_delete'),
    path('<int:pk>/', views.MaintenanceView.as_view(), name='maintenance'),
    path('<int:pk>/edit/', views.MaintenanceEditView.as_view(), name='maintenance_edit'),
    path('<int:pk>/delete/', views.MaintenanceDeleteView.as_view(), name='maintenance_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='maintenance_changelog', kwargs={
        'model': Maintenance,
    }),

    path('update/edit/', views.MaintenanceUpdateBulkEditView.as_view(), name='maintenanceupdate_bulk_edit'),
    path('update/delete/', views.MaintenanceUpdateBulkDeleteView.as_view(), name='maintenanceupdate_bulk_delete'),
    path('update/<int:pk>/', views.MaintenanceUpdateView.as_view(), name='maintenanceupdate'),
    path('update/<int:pk>/edit/', views.MaintenanceUpdateEditView.as_view(), name='maintenanceupdate_edit'),
    path('update/<int:pk>/delete/', views.MaintenanceUpdateDeleteView.as_view(), name='maintenanceupdate_delete'),
    path('update/<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='maintenanceupdate_changelog', kwargs={
        'model': MaintenanceUpdate,
    }),

    path('past/', views.PastMaintenanceListView.as_view(), name='past'),
]
