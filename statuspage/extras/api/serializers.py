from django.contrib.contenttypes.models import ContentType
from drf_yasg.utils import swagger_serializer_method
from rest_framework import serializers

from extras.choices import *
from extras.models import *
from extras.utils import FeatureQuery
from statuspage.api.exceptions import SerializerNotFound
from statuspage.api.fields import ChoiceField, ContentTypeField
from statuspage.api.serializers import BaseModelSerializer, ValidatedModelSerializer
from statuspage.constants import NESTED_SERIALIZER_PREFIX
from subscribers.api.nested_serializers import NestedSubscriberSerializer
from users.api.nested_serializers import NestedUserSerializer
from utilities.api import get_serializer_for_model

__all__ = (
    'ContentTypeSerializer',
    'ObjectChangeSerializer',
    'WebhookSerializer',
)


#
# Webhooks
#

class WebhookSerializer(ValidatedModelSerializer):
    url = serializers.HyperlinkedIdentityField(view_name='extras-api:webhook-detail')
    content_types = ContentTypeField(
        queryset=ContentType.objects.filter(FeatureQuery('webhooks').get_query()),
        many=True
    )
    subscriber = NestedSubscriberSerializer()

    class Meta:
        model = Webhook
        fields = [
            'id', 'url', 'display', 'subscriber', 'content_types', 'name', 'type_create', 'type_update', 'type_delete',
            'payload_url', 'enabled', 'http_method', 'http_content_type',
            'additional_headers', 'body_template', 'secret', 'conditions', 'ssl_verification', 'ca_file_path',
            'created', 'last_updated',
        ]


#
# Change logging
#

class ObjectChangeSerializer(BaseModelSerializer):
    url = serializers.HyperlinkedIdentityField(view_name='extras-api:objectchange-detail')
    user = NestedUserSerializer(
        read_only=True
    )
    action = ChoiceField(
        choices=ObjectChangeActionChoices,
        read_only=True
    )
    changed_object_type = ContentTypeField(
        read_only=True
    )
    changed_object = serializers.SerializerMethodField(
        read_only=True
    )

    class Meta:
        model = ObjectChange
        fields = [
            'id', 'url', 'display', 'time', 'user', 'user_name', 'request_id', 'action', 'changed_object_type',
            'changed_object_id', 'changed_object', 'prechange_data', 'postchange_data',
        ]

    @swagger_serializer_method(serializer_or_field=serializers.JSONField)
    def get_changed_object(self, obj):
        """
        Serialize a nested representation of the changed object.
        """
        if obj.changed_object is None:
            return None

        try:
            serializer = get_serializer_for_model(obj.changed_object, prefix=NESTED_SERIALIZER_PREFIX)
        except SerializerNotFound:
            return obj.object_repr
        context = {
            'request': self.context['request']
        }
        data = serializer(obj.changed_object, context=context).data

        return data


#
# ContentTypes
#

class ContentTypeSerializer(BaseModelSerializer):
    url = serializers.HyperlinkedIdentityField(view_name='extras-api:contenttype-detail')

    class Meta:
        model = ContentType
        fields = ['id', 'url', 'display', 'app_label', 'model']
