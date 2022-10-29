from django.db import models
from django.urls import reverse
from incidents.choices import *
from django.contrib.auth.models import User
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

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return self.title

    def get_absolute_url(self):
        return reverse('incidents:incident', args=[self.pk])

    def get_impact_color(self):
        return IncidentImpactChoices.colors.get(self.impact)


class IncidentUpdate(IncidentMaintenanceUpdateModel):
    incident = models.ForeignKey(
        to=Incident,
        on_delete=models.CASCADE,
        related_name='incident_updates',
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

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.incident.title} - Update {self.pk}'

    def get_absolute_url(self):
        return reverse('incidents:incidentupdate', args=[self.pk])
