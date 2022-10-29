from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import Incident, IncidentUpdate

app_name = 'incidents'
urlpatterns = [
    path('', views.IncidentListView.as_view(), name='incident_list'),
    path('add/', views.IncidentEditView.as_view(), name='incident_add'),
    path('edit/', views.IncidentBulkEditView.as_view(), name='incident_bulk_edit'),
    path('delete/', views.IncidentBulkDeleteView.as_view(), name='incident_bulk_delete'),
    path('<int:pk>/', views.IncidentView.as_view(), name='incident'),
    path('<int:pk>/edit/', views.IncidentEditView.as_view(), name='incident_edit'),
    path('<int:pk>/delete/', views.IncidentDeleteView.as_view(), name='incident_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='incident_changelog', kwargs={
        'model': Incident,
    }),

    path('update/edit/', views.IncidentUpdateBulkEditView.as_view(), name='incidentupdate_bulk_edit'),
    path('update/delete/', views.IncidentUpdateBulkDeleteView.as_view(), name='incidentupdate_bulk_delete'),
    path('update/<int:pk>/', views.IncidentUpdateView.as_view(), name='incidentupdate'),
    path('update/<int:pk>/edit/', views.IncidentUpdateEditView.as_view(), name='incidentupdate_edit'),
    path('update/<int:pk>/delete/', views.IncidentUpdateDeleteView.as_view(), name='incidentupdate_delete'),
    path('update/<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='incidentupdate_changelog', kwargs={
        'model': IncidentUpdate,
    }),

    path('past/', views.PastIncidentListView.as_view(), name='past'),
]
