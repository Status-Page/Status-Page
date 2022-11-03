from django.db import models
from django.template import Context, Template
from django.utils.safestring import mark_safe

from statuspage.models import StatusPageModel
from django.urls import reverse
from .choices import *
import json


class Metric(StatusPageModel):
    title = models.CharField(
        max_length=255
    )
    suffix = models.CharField(
        max_length=15,
    )
    visibility = models.BooleanField(
        default=False,
    )
    order = models.IntegerField(
        default=1,
    )
    expand = models.CharField(
        max_length=255,
        choices=MetricExpandChoices,
        default=MetricExpandChoices.ON_CLICK,
    )

    class Meta:
        ordering = ['order', 'pk']

    def __str__(self):
        return self.title

    def get_absolute_url(self):
        return reverse('metrics:metric', args=[self.pk])

    def get_metric_data(self, now, range):
        return self.points.filter(created__range=(range, now))

    def get_metric_labels_json(self, now, range):
        labels = []
        for point in self.get_metric_data(now=now, range=range):
            template = Template('{{ point.created }}')
            context = Context()
            context.update({'point': point})
            labels.append(template.render(context))
        return mark_safe(json.dumps(labels))

    def get_metric_points_json(self, now, range):
        points = []
        for point in self.get_metric_data(now=now, range=range):
            points.append(point.value)
        return mark_safe(json.dumps(points))

    @property
    def should_expand(self):
        if self.expand == MetricExpandChoices.ALWAYS:
            return 'true'
        return 'false'


class MetricPoint(StatusPageModel):
    metric = models.ForeignKey(
        to=Metric,
        on_delete=models.CASCADE,
        related_name='points',
    )
    value = models.FloatField()

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.value}'

    def get_absolute_url(self):
        return reverse('metrics:metric', args=[self.pk])
