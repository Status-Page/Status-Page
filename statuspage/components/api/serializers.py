from rest_framework import serializers

from components.api.nested_serializers import NestedComponentGroupSerializer
from components.choices import ComponentStatusChoices, ComponentGroupCollapseChoices
from components.models import Component, ComponentGroup
from statuspage.api.serializers import StatusPageModelSerializer


class ComponentGroupSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:componentgroup-detail'
    )
    collapse = serializers.ChoiceField(
        choices=ComponentGroupCollapseChoices,
        default=ComponentGroupCollapseChoices.ON_ISSUE
    )

    class Meta:
        model = ComponentGroup
        fields = ('id', 'url', 'name', 'description', 'visibility', 'order', 'collapse')


class ComponentSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:component-detail'
    )
    status = serializers.ChoiceField(
        choices=ComponentStatusChoices,
        default=ComponentStatusChoices.OPERATIONAL
    )
    component_group = NestedComponentGroupSerializer()

    class Meta:
        model = Component
        fields = ('id', 'url', 'name', 'link', 'description', 'component_group', 'visibility', 'status', 'order')
