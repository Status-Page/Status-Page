from django.urls import path, include

from utilities.urls import get_model_urls
from . import views # noqa Required for registration

app_name = 'incidents'
urlpatterns = [
    path('', include(get_model_urls('incidents', 'incident'))),
    path('update/', include(get_model_urls('incidents', 'incidentupdate'))),
    path('template/', include(get_model_urls('incidents', 'incidenttemplate'))),
]
