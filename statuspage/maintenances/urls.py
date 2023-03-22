from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import Maintenance, MaintenanceUpdate, MaintenanceTemplate

app_name = 'maintenances'
urlpatterns = [
    path('', views.MaintenanceListView.as_view(), name='maintenance_list'),
    path('add/', views.MaintenanceCreateView.as_view(), name='maintenance_add'),
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

    path('template/', views.MaintenanceTemplateListView.as_view(), name='maintenancetemplate_list'),
    path('template/add/', views.MaintenanceTemplateEditView.as_view(), name='maintenancetemplate_add'),
    path('template/edit/', views.MaintenanceTemplateBulkEditView.as_view(), name='maintenancetemplate_bulk_edit'),
    path('template/delete/', views.MaintenanceTemplateBulkDeleteView.as_view(), name='maintenancetemplate_bulk_delete'),
    path('template/<int:pk>/', views.MaintenanceTemplateView.as_view(), name='maintenancetemplate'),
    path('template/<int:pk>/edit/', views.MaintenanceTemplateEditView.as_view(), name='maintenancetemplate_edit'),
    path('template/<int:pk>/delete/', views.MaintenanceTemplateDeleteView.as_view(), name='maintenancetemplate_delete'),
    path('template/<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='maintenancetemplate_changelog', kwargs={
        'model': MaintenanceTemplate,
    }),

    path('past/', views.PastMaintenanceListView.as_view(), name='past'),
]
