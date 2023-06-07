from django.urls import path, include

from utilities.urls import get_model_urls

from . import views # noqa Required for registration

app_name = 'extras'
urlpatterns = [
    path('changelog/', include(get_model_urls('extras', 'objectchange'))),
    path('webhooks/', include(get_model_urls('extras', 'webhook'))),
]
