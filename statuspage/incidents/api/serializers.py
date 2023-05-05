from rest_framework import serializers

from components.api.nested_serializers import NestedComponentSerializer
from incidents.api.nested_serializers import NestedIncidentSerializer
from incidents.choices import IncidentStatusChoices, IncidentImpactChoices
from incidents.models import Incident, IncidentUpdate, IncidentTemplate
from statuspage.api.serializers import StatusPageModelSerializer
from users.api.nested_serializers import NestedUserSerializer


class IncidentSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incident-detail'
    )
    status = serializers.ChoiceField(
        choices=IncidentStatusChoices,
        default=IncidentStatusChoices.INVESTIGATING,
    )
    impact = serializers.ChoiceField(
        choices=IncidentImpactChoices,
        default=IncidentImpactChoices.NONE,
    )
    user = NestedUserSerializer()
    components = serializers.ManyRelatedField(
        child_relation=NestedComponentSerializer(),
        default=[],
    )

    class Meta:
        model = Incident
        fields = ('id', 'url', 'title', 'visibility', 'status', 'impact', 'user', 'components', 'created',
                  'last_updated')


class IncidentUpdateSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incident-detail'
    )
    incident = NestedIncidentSerializer()
    status = serializers.ChoiceField(
        choices=IncidentStatusChoices,
        default=IncidentStatusChoices.INVESTIGATING,
    )
    user = NestedUserSerializer()

    class Meta:
        model = IncidentUpdate
        fields = ('id', 'url', 'text', 'new_status', 'incident', 'status', 'user', 'created', 'last_updated')


class IncidentTemplateSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incidenttemplate-detail'
    )
    status = serializers.ChoiceField(
        choices=IncidentStatusChoices,
        default=IncidentStatusChoices.INVESTIGATING,
    )
    impact = serializers.ChoiceField(
        choices=IncidentImpactChoices,
        default=IncidentImpactChoices.NONE,
    )
    components = serializers.ManyRelatedField(
        child_relation=NestedComponentSerializer(),
        default=[],
    )

    class Meta:
        model = IncidentTemplate
        fields = ('id', 'url', 'template_name', 'title', 'visibility', 'status', 'impact', 'components',
                  'update_component_status', 'text', 'created', 'last_updated')
