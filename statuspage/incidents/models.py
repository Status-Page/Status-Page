from django.db import models
from django.urls import reverse
from incidents.choices import *
from django.contrib.auth.models import User
from components.models import Component
from subscribers.models import Subscriber
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

    def save(self, **kwargs):
        is_new = self.pk is None

        super().save(**kwargs)

        if is_new and self.visibility:
            try:
                subscribers = Subscriber.objects.filter(incident_subscriptions=True)

                for subscriber in subscribers:
                    subscriber.send_mail(subject=f'Incident "{self.title}": Created', template='incidents/created', context={
                        'incident': self,
                        'components': self.components.filter(visibility=True),
                    })
            except:
                pass

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

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.incident.title} - Update {self.pk}'

    def get_absolute_url(self):
        return reverse('incidents:incidentupdate', args=[self.pk])

    def save(self, **kwargs):
        is_new = self.pk is None

        super().save(**kwargs)

        if is_new and self.incident.visibility:
            try:
                subscribers = Subscriber.objects.filter(incident_subscriptions=True)

                for subscriber in subscribers:
                    subscriber.send_mail(subject=f'Incident "{self.incident.title}": Update Posted', template='incidentupdates/created', context={
                        'incident': self.incident,
                        'update': self,
                        'components': self.incident.components.filter(visibility=True),
                    })
            except:
                pass
