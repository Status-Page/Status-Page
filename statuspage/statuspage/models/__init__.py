from django.db import models

from utilities.querysets import RestrictedQuerySet
from statuspage.models.features import *

__all__ = (
    'ChangeLoggedModel',
    'StatusPageModel',
)


class StatusPageFeatureSet(
    ChangeLoggingMixin,
):
    class Meta:
        abstract = True

    @classmethod
    def get_prerequisite_models(cls):
        """
        Return a list of model types that are required to create this model or empty list if none.  This is used for
        showing prerequisite warnings in the UI on the list and detail views.
        """
        return []


#
# Base model classes
#

class ChangeLoggedModel(ChangeLoggingMixin, models.Model):
    """
    Base model for ancillary models; provides limited functionality for models which don't
    support Status-Page's full feature set.
    """
    objects = RestrictedQuerySet.as_manager()

    class Meta:
        abstract = True


class StatusPageModel(StatusPageFeatureSet, models.Model):
    """
    Primary models represent real objects within the infrastructure being modeled.
    """
    objects = RestrictedQuerySet.as_manager()

    class Meta:
        abstract = True
