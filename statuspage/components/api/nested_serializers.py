from rest_framework import serializers
from statuspage.api.serializers import WritableNestedSerializer
from components.models import ComponentGroup, Component


class NestedComponentGroupSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:componentgroup-detail'
    )

    class Meta:
        model = ComponentGroup
        fields = ('id', 'url', 'display', 'name', 'description', 'order')


class NestedComponentSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:component-detail'
    )

    class Meta:
        model = Component
        fields = ('id', 'url', 'display', 'name', 'description', 'status', 'order')
