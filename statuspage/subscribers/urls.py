from django.urls import path

from statuspage.views.generic import ObjectChangeLogView
from . import views
from .models import Subscriber

app_name = 'subscribers'
urlpatterns = [
    path('', views.SubscriberListView.as_view(), name='subscriber_list'),
    path('add/', views.SubscriberEditView.as_view(), name='subscriber_add'),
    path('delete/', views.SubscriberBulkDeleteView.as_view(), name='subscriber_bulk_delete'),
    path('<int:pk>/', views.SubscriberView.as_view(), name='subscriber'),
    # path('<int:pk>/edit/', views.SubscriberEditView.as_view(), name='subscriber_edit'),
    path('<int:pk>/delete/', views.SubscriberDeleteView.as_view(), name='subscriber_delete'),
    path('<int:pk>/changelog/', ObjectChangeLogView.as_view(), name='subscriber_changelog', kwargs={
        'model': Subscriber,
    }),
]
