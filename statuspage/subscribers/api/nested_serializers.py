from rest_framework import serializers

from subscribers import models
from statuspage.api.serializers import WritableNestedSerializer

__all__ = [
    'NestedSubscriberSerializer',
]


class NestedSubscriberSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(view_name='subscribers-api:subscriber-detail')

    class Meta:
        model = models.Subscriber
        fields = ['id', 'url', 'email']
