from rest_framework.routers import APIRootView
from rest_framework.viewsets import ModelViewSet

from maintenances.api import serializers
from maintenances import filtersets
from maintenances.models import Maintenance, MaintenanceUpdate


class MaintenancesRootView(APIRootView):
    """
    Components API root view
    """
    def get_view_name(self):
        return 'Maintenances'


class MaintenanceViewSet(ModelViewSet):
    queryset = Maintenance.objects.all()
    serializer_class = serializers.MaintenanceSerializer
    filterset_class = filtersets.MaintenanceFilterSet


class MaintenanceUpdateViewSet(ModelViewSet):
    queryset = MaintenanceUpdate.objects.all()
    serializer_class = serializers.MaintenanceUpdateSerializer
    filterset_class = filtersets.MaintenanceUpdateFilterSet
