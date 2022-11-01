from rest_framework import serializers

from incidents.models import Incident, IncidentUpdate
from statuspage.api.serializers import WritableNestedSerializer


class NestedIncidentSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incident-detail'
    )

    class Meta:
        model = Incident
        fields = ('id', 'url', 'display', 'title', 'status', 'impact')


class NestedIncidentUpdateSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='incidents-api:incidentupdate-detail'
    )

    class Meta:
        model = IncidentUpdate
        fields = ('id', 'url', 'display', 'text', 'new_status', 'status')
