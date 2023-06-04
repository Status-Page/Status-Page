from django.urls import path, include

from utilities.urls import get_model_urls
from . import views # noqa Required for registration

app_name = 'subscribers'
urlpatterns = [
    path('', include(get_model_urls('subscribers', 'subscriber'))),
]
