from rest_framework.routers import APIRootView
from rest_framework.viewsets import ModelViewSet

from components.api import serializers
from components import filtersets
from components.models import Component, ComponentGroup


class ComponentsRootView(APIRootView):
    """
    Components API root view
    """
    def get_view_name(self):
        return 'Components'


class ComponentGroupViewSet(ModelViewSet):
    queryset = ComponentGroup.objects.all()
    serializer_class = serializers.ComponentGroupSerializer
    filterset_class = filtersets.ComponentGroupFilterSet


class ComponentViewSet(ModelViewSet):
    queryset = Component.objects.all()
    serializer_class = serializers.ComponentSerializer
    filterset_class = filtersets.ComponentFilterSet
