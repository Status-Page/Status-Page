from django.urls import path, include

from utilities.urls import get_model_urls

from . import views # noqa Required for registration

app_name = 'components'
urlpatterns = [
    path('', include(get_model_urls('components', 'component'))),
    path('groups/', include(get_model_urls('components', 'componentgroup'))),
]
