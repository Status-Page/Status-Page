from django.urls import path, include

from utilities.urls import get_model_urls
from . import views # noqa Required for registration

urlpatterns = [
    path('', include(get_model_urls('sp_uptimerobot', 'uptimerobotmonitor'))),
]
