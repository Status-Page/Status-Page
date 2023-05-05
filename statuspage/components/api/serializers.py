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
        fields = ('id', 'url', 'name', 'description', 'visibility', 'order', 'collapse', 'created', 'last_updated')


class ComponentSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='components-api:component-detail'
    )
    status = serializers.ChoiceField(
        choices=ComponentStatusChoices,
        default=ComponentStatusChoices.OPERATIONAL
    )
    component_group = NestedComponentGroupSerializer(
        required=False
    )

    class Meta:
        model = Component
        fields = ('id', 'url', 'name', 'link', 'description', 'component_group', 'show_historic_incidents',
                  'visibility', 'status', 'order', 'created', 'last_updated')
