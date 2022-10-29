from django.contrib.contenttypes.models import ContentType
from rest_framework.permissions import IsAuthenticated
from rest_framework.routers import APIRootView
from rest_framework.viewsets import ReadOnlyModelViewSet

from extras import filtersets
from extras.models import *
from statuspage.api.metadata import ContentTypeMetadata
from . import serializers


class ExtrasRootView(APIRootView):
    """
    Extras API root view
    """
    def get_view_name(self):
        return 'Extras'


#
# Change logging
#

class ObjectChangeViewSet(ReadOnlyModelViewSet):
    """
    Retrieve a list of recent changes.
    """
    metadata_class = ContentTypeMetadata
    queryset = ObjectChange.objects.prefetch_related('user')
    serializer_class = serializers.ObjectChangeSerializer
    filterset_class = filtersets.ObjectChangeFilterSet


#
# ContentTypes
#

class ContentTypeViewSet(ReadOnlyModelViewSet):
    """
    Read-only list of ContentTypes. Limit results to ContentTypes pertinent to StatusPage objects.
    """
    permission_classes = (IsAuthenticated,)
    queryset = ContentType.objects.order_by('app_label', 'model')
    serializer_class = serializers.ContentTypeSerializer
    filterset_class = filtersets.ContentTypeFilterSet
