from django.db import models
from statuspage.models import StatusPageModel
from django.urls import reverse
from components.choices import *


class ComponentGroup(StatusPageModel):
    name = models.CharField(
        max_length=255,
    )
    description = models.CharField(
        max_length=255,
        blank=True,
    )
    visibility = models.BooleanField(
        default=False,
    )
    order = models.IntegerField(
        default=1,
    )
    collapse = models.CharField(
        max_length=255,
        choices=ComponentGroupCollapseChoices,
        default='expand_issue'
    )

    class Meta:
        ordering = ['order', 'pk']

    def __str__(self):
        return self.name

    def get_absolute_url(self):
        return reverse('components:componentgroup', args=[self.pk])

    @property
    def should_expand(self):
        if self.collapse == ComponentGroupCollapseChoices.ALWAYS:
            return 'true'
        for component in self.components.all():
            if component.status != ComponentStatusChoices.OPERATIONAL:
                return 'true'
        return 'false'


class Component(StatusPageModel):
    name = models.CharField(
        max_length=255,
    )
    link = models.URLField(
        blank=True,
    )
    description = models.CharField(
        max_length=255,
        blank=True,
    )
    component_group = models.ForeignKey(
        to=ComponentGroup,
        on_delete=models.CASCADE,
        related_name='components',
        blank=True,
        null=True,
    )
    visibility = models.BooleanField(
        default=False,
    )
    status = models.CharField(
        max_length=255,
        choices=ComponentStatusChoices,
        default='operational',
    )
    order = models.IntegerField(
        default=1,
    )

    class Meta:
        ordering = ['component_group', 'order', 'pk']

    def __str__(self):
        return self.name

    def get_absolute_url(self):
        return reverse('components:component', args=[self.pk])

    def get_status_color(self):
        (color, _) = ComponentStatusChoices.colors.get(self.status)
        return color

    def get_status_text_color(self):
        (_, color) = ComponentStatusChoices.colors.get(self.status)
        return color
