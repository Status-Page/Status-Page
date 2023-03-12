from rest_framework.routers import APIRootView
from rest_framework.viewsets import ModelViewSet

from incidents.api import serializers
from incidents import filtersets
from incidents.models import Incident, IncidentUpdate, IncidentTemplate


class IncidentsRootView(APIRootView):
    """
    Components API root view
    """
    def get_view_name(self):
        return 'Incidents'


class IncidentViewSet(ModelViewSet):
    queryset = Incident.objects.all()
    serializer_class = serializers.IncidentSerializer
    filterset_class = filtersets.IncidentFilterSet


class IncidentUpdateViewSet(ModelViewSet):
    queryset = IncidentUpdate.objects.all()
    serializer_class = serializers.IncidentUpdateSerializer
    filterset_class = filtersets.IncidentUpdateFilterSet


class IncidentTemplateViewSet(ModelViewSet):
    queryset = IncidentTemplate.objects.all()
    serializer_class = serializers.IncidentTemplateSerializer
    filterset_class = filtersets.IncidentTemplateFilterSet
