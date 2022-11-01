from rest_framework.routers import APIRootView
from rest_framework.viewsets import ModelViewSet

from metrics.api import serializers
from metrics import filtersets
from metrics.models import Metric, MetricPoint


class MetricsRootView(APIRootView):
    """
    Components API root view
    """
    def get_view_name(self):
        return 'Metrics'


class MetricViewSet(ModelViewSet):
    queryset = Metric.objects.all()
    serializer_class = serializers.MetricSerializer
    filterset_class = filtersets.MetricFilterSet


class MetricPointViewSet(ModelViewSet):
    queryset = MetricPoint.objects.all()
    serializer_class = serializers.MetricPointSerializer
    filterset_class = filtersets.MetricPointFilterSet
