from django.db import models
from django.urls import reverse

from components.choices import ComponentStatusChoices
from components.models import Component
from sp_external_status_providers.choices import ExternalStatusPageProviderChoices
from sp_external_status_providers.providers.atlassian import AtlassianProvider
from statuspage.models import StatusPageModel


class ExternalStatusPage(StatusPageModel):
    domain = models.CharField(
        max_length=255,
    )
    provider = models.CharField(
        max_length=255,
        choices=ExternalStatusPageProviderChoices,
    )
    create_incidents = models.BooleanField(
        default=False,
    )
    create_maintenances = models.BooleanField(
        default=False,
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.domain}'

    def get_absolute_url(self):
        return reverse('plugins:sp_external_status_providers:externalstatuspage', args=[self.pk])

    @property
    def provider_class(self):
        match self.provider:
            case ExternalStatusPageProviderChoices.ATLASSIAN_STATUSPAGE:
                return AtlassianProvider


class ExternalStatusComponent(StatusPageModel):
    page_object_id = models.CharField(
        max_length=255,
    )
    name = models.CharField(
        max_length=255,
    )
    external_page = models.ForeignKey(
        to=ExternalStatusPage,
        on_delete=models.CASCADE,
        related_name='components',
    )
    component = models.ForeignKey(
        to=Component,
        on_delete=models.SET_NULL,
        blank=True,
        null=True,
    )
    group_name = models.CharField(
        max_length=255,
        blank=True,
        null=True,
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return f'{self.name}'

    def get_absolute_url(self):
        return reverse('plugins:sp_external_status_providers:externalstatuscomponent', args=[self.pk])

    @classmethod
    def status(cls, status_name):
        match status_name:
            case 'operational':
                return ComponentStatusChoices.OPERATIONAL
            case 'degraded_performance':
                return ComponentStatusChoices.DEGRADED_PERFORMANCE
            case 'partial_outage':
                return ComponentStatusChoices.PARTIAL_OUTAGE
            case 'major_outage':
                return ComponentStatusChoices.MAJOR_OUTAGE
            case 'under_maintenance':
                return ComponentStatusChoices.MAINTENANCE
            case _:
                return ComponentStatusChoices.UNKNOWN

    @classmethod
    def by_object_id(cls, component_id):
        try:
            return cls.objects.get(page_object_id=component_id)
        except:
            return None
