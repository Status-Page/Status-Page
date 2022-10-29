from django.urls import path

from . import views

app_name = 'extras'
urlpatterns = [
    path('changelog/', views.ObjectChangeListView.as_view(), name='objectchange_list'),
    path('changelog/<int:pk>/', views.ObjectChangeView.as_view(), name='objectchange'),
]
