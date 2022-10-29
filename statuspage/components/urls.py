from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import Component, ComponentGroup

app_name = 'components'
urlpatterns = [
    path('', views.ComponentListView.as_view(), name='component_list'),
    path('add/', views.ComponentEditView.as_view(), name='component_add'),
    path('edit/', views.ComponentBulkEditView.as_view(), name='component_bulk_edit'),
    path('delete/', views.ComponentBulkDeleteView.as_view(), name='component_bulk_delete'),
    path('<int:pk>/', views.ComponentView.as_view(), name='component'),
    path('<int:pk>/edit/', views.ComponentEditView.as_view(), name='component_edit'),
    path('<int:pk>/delete/', views.ComponentDeleteView.as_view(), name='component_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='component_changelog', kwargs={
        'model': Component,
    }),

    path('groups/', views.ComponentGroupListView.as_view(), name='componentgroup_list'),
    path('groups/add/', views.ComponentGroupEditView.as_view(), name='componentgroup_add'),
    path('groups/edit/', views.ComponentGroupBulkEditView.as_view(), name='componentgroup_bulk_edit'),
    path('groups/delete/', views.ComponentGroupBulkDeleteView.as_view(), name='componentgroup_bulk_delete'),
    path('groups/<int:pk>/', views.ComponentGroupView.as_view(), name='componentgroup'),
    path('groups/<int:pk>/edit/', views.ComponentGroupEditView.as_view(), name='componentgroup_edit'),
    path('groups/<int:pk>/delete/', views.ComponentGroupDeleteView.as_view(), name='componentgroup_delete'),
    path('groups/<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='componentgroup_changelog', kwargs={
        'model': ComponentGroup,
    }),
]
