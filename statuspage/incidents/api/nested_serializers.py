from rest_framework import serializers

from incidents.models import Incident, IncidentUpdate, IncidentTemplate
from statuspage.api.serializers import WritableNestedSerializer


class NestedIncidentSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incident-detail'
    )

    class Meta:
        model = Incident
        fields = ('id', 'url', 'display', 'title', 'status', 'impact', 'created', 'last_updated')


class NestedIncidentUpdateSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incidentupdate-detail'
    )

    class Meta:
        model = IncidentUpdate
        fields = ('id', 'url', 'display', 'text', 'new_status', 'status', 'created', 'last_updated')


class NestedIncidentTemplateSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incidenttemplate-detail'
    )

    class Meta:
        model = IncidentTemplate
        fields = ('id', 'url', 'display', 'template_name', 'title', 'status', 'impact', 'created', 'last_updated')
