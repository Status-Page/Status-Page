from django.db import models
from django.urls import reverse
from django.utils import timezone
from django.contrib.auth.models import User

from maintenances.choices import *
from components.models import Component
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
    created = models.DateTimeField(default=timezone.now)

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return self.title

    def get_absolute_url(self):
        return reverse('maintenances:maintenance', args=[self.pk])

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
    created = models.DateTimeField(default=timezone.now)

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.maintenance.title} - Update {self.id}'

    def get_absolute_url(self):
        return reverse('maintenances:maintenanceupdate', args=[self.pk])


class MaintenanceTemplate(IncidentMaintenanceModel):
    template_name = models.CharField(
        max_length=255,
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
    components = models.ManyToManyField(
        to=Component,
        related_name='+',
        blank=True,
    )
    start_automatically = models.BooleanField(
        default=True,
    )
    end_automatically = models.BooleanField(
        default=True,
    )
    update_component_status = models.BooleanField(
        default=False,
    )
    text = models.CharField(
        max_length=65536,
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return self.template_name

    def get_absolute_url(self):
        return reverse('maintenances:maintenancetemplate', args=[self.pk])

    def get_impact_color(self):
        (color, _, __) = MaintenanceImpactChoices.colors.get(self.impact)
        return color

    def get_impact_border_color(self):
        (_, color, __) = MaintenanceImpactChoices.colors.get(self.impact)
        return color

    def get_impact_text_color(self):
        (_, __, color) = MaintenanceImpactChoices.colors.get(self.impact)
        return color
