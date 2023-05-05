from rest_framework import serializers
from statuspage.api.serializers import WritableNestedSerializer
from components.models import ComponentGroup, Component


class NestedComponentGroupSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:componentgroup-detail'
    )

    class Meta:
        model = ComponentGroup
        fields = ('id', 'url', 'display', 'name', 'description', 'order', 'created', 'last_updated')


class NestedComponentSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:component-detail'
    )
    component_group = NestedComponentGroupSerializer(
        required=False
    )

    class Meta:
        model = Component
        fields = ('id', 'url', 'display', 'name', 'description', 'status', 'order', 'component_group', 'created',
                  'last_updated')
