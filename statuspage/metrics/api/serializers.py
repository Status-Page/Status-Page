from rest_framework import serializers

from metrics.api.nested_serializers import NestedMetricSerializer
from metrics.models import Metric, MetricPoint
from statuspage.api.serializers import StatusPageModelSerializer


class MetricSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='metrics-api:metric-detail'
    )

    class Meta:
        model = Metric
        fields = ('id', 'url', 'title', 'suffix', 'visibility', 'order', 'expand')


class MetricPointSerializer(StatusPageModelSerializer):
    url = serializers.HyperlinkedIdentityField(
        view_name='metrics-api:metricpoint-detail'
    )
    metric = NestedMetricSerializer()

    class Meta:
        model = MetricPoint
        fields = ('id', 'url', 'metric', 'value')
