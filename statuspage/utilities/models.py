from django.db import models
from statuspage.models import StatusPageModel


class IncidentMaintenanceModel(StatusPageModel):
    title = models.CharField(
        max_length=255,
    )
    visibility = models.BooleanField(
        default=False,
    )

    class Meta:
        abstract = True


class IncidentMaintenanceUpdateModel(StatusPageModel):
    text = models.CharField(
        max_length=65536,
    )
    new_status = models.BooleanField(
        default=False,
    )

    class Meta:
        abstract = True
