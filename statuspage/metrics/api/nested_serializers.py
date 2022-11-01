from rest_framework import serializers

from metrics.models import Metric, MetricPoint
from statuspage.api.serializers import WritableNestedSerializer


class NestedMetricSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='metrics-api:metric-detail'
    )

    class Meta:
        model = Metric
        fields = ('id', 'url', 'display', 'suffix', 'visibility', 'order')


class NestedMetricPointSerializer(WritableNestedSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='metrics-api:metricpoint-detail'
    )

    class Meta:
        model = MetricPoint
        fields = ('id', 'url', 'display', 'value')
