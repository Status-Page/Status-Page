from rest_framework.routers import APIRootView
from rest_framework.viewsets import ModelViewSet

from subscribers.api import serializers
from subscribers import filtersets
from subscribers.models import Subscriber


class SubscribersRootView(APIRootView):
    """
    Components API root view
    """
    def get_view_name(self):
        return 'Subscribers'


class SubscriberViewSet(ModelViewSet):
    queryset = Subscriber.objects.all()
    serializer_class = serializers.SubscriberSerializer
    filterset_class = filtersets.SubscriberFilterSet
