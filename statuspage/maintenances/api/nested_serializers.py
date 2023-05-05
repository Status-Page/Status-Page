from rest_framework import serializers

from maintenances.models import Maintenance, MaintenanceUpdate, MaintenanceTemplate
from statuspage.api.serializers import WritableNestedSerializer


class NestedMaintenanceSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenance-detail'
    )

    class Meta:
        model = Maintenance
        fields = ('id', 'url', 'display', 'title', 'status', 'impact', 'created', 'last_updated')


class NestedMaintenanceUpdateSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenanceupdate-detail'
    )

    class Meta:
        model = MaintenanceUpdate
        fields = ('id', 'url', 'display', 'text', 'new_status', 'status', 'created', 'last_updated')


class NestedMaintenanceTemplateSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenancetemplate-detail'
    )

    class Meta:
        model = MaintenanceTemplate
        fields = ('id', 'url', 'display', 'template_name', 'title', 'status', 'impact', 'created', 'last_updated')
