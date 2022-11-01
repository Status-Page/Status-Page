from rest_framework import serializers

from components.api.nested_serializers import NestedComponentSerializer
from subscribers.models import Subscriber
from statuspage.api.serializers import StatusPageModelSerializer


class SubscriberSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='subscribers-api:subscriber-detail'
    )
    component_subscriptions = serializers.ManyRelatedField(
        child_relation=NestedComponentSerializer(),
        default=[],
    )

    class Meta:
        model = Subscriber
        fields = ('id', 'url', 'email', 'email_verified_at', 'management_key', 'incident_subscriptions', 'component_subscriptions')
