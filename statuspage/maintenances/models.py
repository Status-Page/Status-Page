from django.db import models
from django.urls import reverse

from components.models import Component
from maintenances.choices import *
from django.contrib.auth.models import User

from subscribers.models import Subscriber
from utilities.models import IncidentMaintenanceModel, IncidentMaintenanceUpdateModel


class Maintenance(IncidentMaintenanceModel):
    scheduled_at = models.DateTimeField()
    end_at = models.DateTimeField()
    start_automatically = models.BooleanField(
        default=True,
    )
    end_automatically = models.BooleanField(
        default=True,
    )
    user = models.ForeignKey(
        to=User,
        on_delete=models.SET_NULL,
        related_name='maintenances',
        blank=True,
        null=True
    )
    components = models.ManyToManyField(
        to=Component,
        related_name='maintenances',
        blank=True,
    )
    status = models.CharField(
        max_length=255,
        choices=MaintenanceStatusChoices,
        default=MaintenanceStatusChoices.SCHEDULED,
    )
    impact = models.CharField(
        max_length=255,
        choices=MaintenanceImpactChoices,
        default=MaintenanceImpactChoices.MAINTENANCE,
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return self.title

    def get_absolute_url(self):
        return reverse('maintenances:maintenance', args=[self.pk])

    def save(self, **kwargs):
        is_new = self.pk is None

        super().save(**kwargs)

        if is_new and self.visibility:
            try:
                subscribers = Subscriber.objects.filter(incident_subscriptions=True)

                for subscriber in subscribers:
                    subscriber.send_mail(subject=f'Maintenance "{self.title}": Created', template='maintenances/created', context={
                        'maintenance': self,
                        'components': self.components.filter(visibility=True),
                    })
            except:
                pass

    def get_impact_color(self):
        (color, _, __) = MaintenanceImpactChoices.colors.get(self.impact)
        return color

    def get_impact_border_color(self):
        (_, color, __) = MaintenanceImpactChoices.colors.get(self.impact)
        return color

    def get_impact_text_color(self):
        (_, __, color) = MaintenanceImpactChoices.colors.get(self.impact)
        return color


class MaintenanceUpdate(IncidentMaintenanceUpdateModel):
    maintenance = models.ForeignKey(
        to=Maintenance,
        on_delete=models.CASCADE,
        related_name='updates',
    )
    status = models.CharField(
        max_length=255,
        choices=MaintenanceStatusChoices,
    )
    user = models.ForeignKey(
        to=User,
        on_delete=models.SET_NULL,
        related_name='maintenance_updates',
        blank=True,
        null=True
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.maintenance.title} - Update {self.id}'

    def get_absolute_url(self):
        return reverse('maintenances:maintenanceupdate', args=[self.pk])

    def save(self, **kwargs):
        is_new = self.pk is None

        super().save(**kwargs)

        if is_new and self.maintenance.visibility:
            try:
                subscribers = Subscriber.objects.filter(incident_subscriptions=True)

                for subscriber in subscribers:
                    subscriber.send_mail(subject=f'Maintenance "{self.maintenance.title}": Update Posted', template='maintenanceupdates/created', context={
                        'maintenance': self.maintenance,
                        'update': self,
                        'components': self.maintenance.components.filter(visibility=True),
                    })
            except:
                pass

