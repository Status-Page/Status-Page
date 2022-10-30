from django.contrib import admin
from django.core.cache import cache
from django.db import models

__all__ = (
    'ConfigRevision',
)


class ConfigRevision(models.Model):
    """
    An atomic revision of Status-Page's configuration.
    """
    created = models.DateTimeField(
        auto_now_add=True
    )
    comment = models.CharField(
        max_length=200,
        blank=True
    )
    data = models.JSONField(
        blank=True,
        null=True,
        verbose_name='Configuration data'
    )

    def __str__(self):
        return f'Config revision #{self.pk} ({self.created})'

    def __getattr__(self, item):
        if item in self.data:
            return self.data[item]
        return super().__getattribute__(item)

    def activate(self):
        """
        Cache the configuration data.
        """
        cache.set('config', self.data, None)
        cache.set('config_version', self.pk, None)

    @admin.display(boolean=True)
    def is_active(self):
        return cache.get('config_version') == self.pk
