from django.urls import path, include

from utilities.urls import get_model_urls
from . import views # noqa Required for registration

urlpatterns = [
    path('', include(get_model_urls('sp_external_status_providers', 'externalstatuspage'))),
    path('components/', include(get_model_urls('sp_external_status_providers', 'externalstatuscomponent'))),
]
