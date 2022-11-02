from django.db import models
from django.urls import reverse

from components.choices import ComponentStatusChoices
from components.models import Component
from metrics.models import Metric
from statuspage.models import StatusPageModel


class UptimeRobotMonitor(StatusPageModel):
    monitor_id = models.CharField(
        max_length=255,
        unique=True,
    )
    friendly_name = models.CharField(
        max_length=255,
    )
    status_id = models.IntegerField()
    component = models.ForeignKey(
        to=Component,
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
    )
    metric = models.ForeignKey(
        to=Metric,
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
    )
    paused = models.BooleanField(
        default=True,
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.friendly_name}'

    def get_absolute_url(self):
        return reverse('plugins:sp_uptimerobot:uptimerobotmonitor', args=[self.pk])

    @property
    def status(self):
        match self.status_id:
            case 0:
                return ComponentStatusChoices.MAINTENANCE
            case 2:
                return ComponentStatusChoices.OPERATIONAL
            case 8:
                return ComponentStatusChoices.PARTIAL_OUTAGE
            case 9:
                return ComponentStatusChoices.MAJOR_OUTAGE
            case _:
                return ComponentStatusChoices.OPERATIONAL

    def get_status_display(self):
        return ComponentStatusChoices.labels.get(self.status)

    def get_status_color(self):
        (color, _) = ComponentStatusChoices.colors.get(self.status)
        return color

    @classmethod
    def has_monitor(cls, monitor_id):
        return len(cls.objects.filter(monitor_id=monitor_id)) > 0

    @classmethod
    def by_monitor_id(cls, monitor_id):
        try:
            return cls.objects.get(monitor_id=monitor_id)
        except:
            return None
