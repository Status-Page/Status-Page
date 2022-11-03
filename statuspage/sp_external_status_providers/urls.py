from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import ExternalStatusPage, ExternalStatusComponent

urlpatterns = [
    path('', views.ExternalStatusPageListView.as_view(), name='externalstatuspage_list'),
    path('add/', views.ExternalStatusPageEditView.as_view(), name='externalstatuspage_add'),
    path('edit/', views.ExternalStatusPageBulkEditView.as_view(), name='externalstatuspage_bulk_edit'),
    path('delete/', views.ExternalStatusPageBulkDeleteView.as_view(), name='externalstatuspage_bulk_delete'),
    path('<int:pk>/', views.ExternalStatusPageView.as_view(), name='externalstatuspage'),
    path('<int:pk>/edit/', views.ExternalStatusPageEditView.as_view(), name='externalstatuspage_edit'),
    path('<int:pk>/delete/', views.ExternalStatusPageDeleteView.as_view(), name='externalstatuspage_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='externalstatuspage_changelog', kwargs={
        'model': ExternalStatusPage,
    }),

    path('components/', views.ExternalStatusComponentListView.as_view(), name='externalstatuscomponent_list'),
    path('components/edit/', views.ExternalStatusComponentBulkEditView.as_view(), name='externalstatuscomponent_bulk_edit'),
    path('components/delete/', views.ExternalStatusComponentBulkDeleteView.as_view(), name='externalstatuscomponent_bulk_delete'),
    path('components/<int:pk>/', views.ExternalStatusComponentView.as_view(), name='externalstatuscomponent'),
    path('components/<int:pk>/edit/', views.ExternalStatusComponentEditView.as_view(), name='externalstatuscomponent_edit'),
    path('components/<int:pk>/delete/', views.ExternalStatusComponentDeleteView.as_view(), name='externalstatuscomponent_delete'),
    path('components/<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='externalstatuscomponent_changelog', kwargs={
        'model': ExternalStatusComponent,
    }),
]
