from rest_framework import serializers

from maintenances.models import Maintenance, MaintenanceUpdate
from statuspage.api.serializers import WritableNestedSerializer


class NestedMaintenanceSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenance-detail'
    )

    class Meta:
        model = Maintenance
        fields = ('id', 'url', 'display', 'title', 'status', 'impact')


class NestedMaintenanceUpdateSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenanceupdate-detail'
    )

    class Meta:
        model = MaintenanceUpdate
        fields = ('id', 'url', 'display', 'text', 'new_status', 'status')
