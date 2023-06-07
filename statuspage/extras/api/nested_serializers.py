from rest_framework import serializers

from extras import models
from statuspage.api.serializers import WritableNestedSerializer

__all__ = [
    'NestedWebhookSerializer',
]


class NestedWebhookSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(view_name='extras-api:webhook-detail')

    class Meta:
        model = models.Webhook
        fields = ['id', 'url', 'display', 'name']
