from django.contrib import admin
from django.urls import path, include
from .views import HomeView

urlpatterns = [
    path('', HomeView.as_view()),
    path('components', include('components.urls')),
    path('incidents', include('incidents.urls')),
    path('maintenances', include('maintenances.urls')),
    path('admin/', admin.site.urls),
    path('__reload__/', include('django_browser_reload.urls')),
]
