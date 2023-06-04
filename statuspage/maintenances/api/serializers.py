from rest_framework import serializers

from components.api.nested_serializers import NestedComponentSerializer
from maintenances.api.nested_serializers import NestedMaintenanceSerializer
from maintenances.choices import MaintenanceStatusChoices, MaintenanceImpactChoices
from maintenances.models import Maintenance, MaintenanceUpdate, MaintenanceTemplate
from statuspage.api.serializers import StatusPageModelSerializer
from users.api.nested_serializers import NestedUserSerializer


class MaintenanceSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenance-detail'
    )
    status = serializers.ChoiceField(
        choices=MaintenanceStatusChoices,
        default=MaintenanceStatusChoices.SCHEDULED,
    )
    impact = serializers.ChoiceField(
        choices=MaintenanceImpactChoices,
        default=MaintenanceImpactChoices.MAINTENANCE,
    )
    user = NestedUserSerializer()
    components = serializers.ManyRelatedField(
        child_relation=NestedComponentSerializer(),
        default=[],
    )

    class Meta:
        model = Maintenance
        fields = ('id', 'url', 'title', 'visibility', 'status', 'impact', 'scheduled_at', 'start_automatically',
                  'end_at', 'end_automatically', 'user', 'components', 'created', 'last_updated')


class MaintenanceUpdateSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenance-detail'
    )
    maintenance = NestedMaintenanceSerializer()
    status = serializers.ChoiceField(
        choices=MaintenanceStatusChoices,
        default=MaintenanceStatusChoices.SCHEDULED,
    )
    user = NestedUserSerializer()

    class Meta:
        model = MaintenanceUpdate
        fields = ('id', 'url', 'text', 'new_status', 'maintenance', 'status', 'user', 'created', 'last_updated')


class MaintenanceTemplateSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='maintenances-api:maintenancetemplate-detail'
    )
    status = serializers.ChoiceField(
        choices=MaintenanceStatusChoices,
        default=MaintenanceStatusChoices.SCHEDULED,
    )
    impact = serializers.ChoiceField(
        choices=MaintenanceImpactChoices,
        default=MaintenanceImpactChoices.MAINTENANCE,
    )
    components = serializers.ManyRelatedField(
        child_relation=NestedComponentSerializer(),
        default=[],
    )

    class Meta:
        model = MaintenanceTemplate
        fields = ('id', 'url', 'template_name', 'title', 'visibility', 'start_automatically', 'end_automatically',
                  'status', 'impact', 'components', 'update_component_status', 'text', 'created', 'last_updated')
