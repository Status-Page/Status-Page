from django.urls import path, include

from utilities.urls import get_model_urls
from . import views # noqa Required for registration

app_name = 'maintenances'
urlpatterns = [
    path('', include(get_model_urls('maintenances', 'maintenance'))),
    path('update/', include(get_model_urls('maintenances', 'maintenanceupdate'))),
    path('template/', include(get_model_urls('maintenances', 'maintenancetemplate'))),
]
