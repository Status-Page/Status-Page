from django.db import models
from django.urls import reverse
from django.utils import timezone
from django.contrib.auth.models import User

from incidents.choices import *
from components.models import Component
from utilities.models import IncidentMaintenanceModel, IncidentMaintenanceUpdateModel


class Incident(IncidentMaintenanceModel):
    status = models.CharField(
        max_length=255,
        choices=IncidentStatusChoices,
        default=IncidentStatusChoices.INVESTIGATING,
    )
    impact = models.CharField(
        max_length=255,
        choices=IncidentImpactChoices,
        default=IncidentImpactChoices.NONE,
    )
    user = models.ForeignKey(
        to=User,
        on_delete=models.SET_NULL,
        related_name='incidents',
        blank=True,
        null=True
    )
    components = models.ManyToManyField(
        to=Component,
        related_name='incidents',
        blank=True,
    )
    created = models.DateTimeField(default=timezone.now)

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return self.title

    def get_absolute_url(self):
        return reverse('incidents:incident', args=[self.pk])

    def get_impact_color(self):
        (color, _, __) = IncidentImpactChoices.colors.get(self.impact)
        return color

    def get_impact_border_color(self):
        (_, color, __) = IncidentImpactChoices.colors.get(self.impact)
        return color

    def get_impact_text_color(self):
        (_, __, color) = IncidentImpactChoices.colors.get(self.impact)
        return color


class IncidentUpdate(IncidentMaintenanceUpdateModel):
    incident = models.ForeignKey(
        to=Incident,
        on_delete=models.CASCADE,
        related_name='updates',
    )
    status = models.CharField(
        max_length=255,
        choices=IncidentStatusChoices,
    )
    user = models.ForeignKey(
        to=User,
        on_delete=models.SET_NULL,
        related_name='incident_updates',
        blank=True,
        null=True
    )
    created = models.DateTimeField(default=timezone.now)

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.incident.title} - Update {self.pk}'

    def get_absolute_url(self):
        return reverse('incidents:incidentupdate', args=[self.pk])


class IncidentTemplate(IncidentMaintenanceModel):
    template_name = models.CharField(
        max_length=255,
    )
    status = models.CharField(
        max_length=255,
        choices=IncidentStatusChoices,
        default=IncidentStatusChoices.INVESTIGATING,
    )
    impact = models.CharField(
        max_length=255,
        choices=IncidentImpactChoices,
        default=IncidentImpactChoices.NONE,
    )
    components = models.ManyToManyField(
        to=Component,
        related_name='+',
        blank=True,
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
        return reverse('incidents:incidenttemplate', args=[self.pk])

    def get_impact_color(self):
        (color, _, __) = IncidentImpactChoices.colors.get(self.impact)
        return color

    def get_impact_border_color(self):
        (_, color, __) = IncidentImpactChoices.colors.get(self.impact)
        return color

    def get_impact_text_color(self):
        (_, __, color) = IncidentImpactChoices.colors.get(self.impact)
        return color
