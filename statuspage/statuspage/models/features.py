from django.db import models
from django.db.models.signals import class_prepared
from django.dispatch import receiver

from extras.choices import ObjectChangeActionChoices
from extras.utils import register_features
from utilities.utils import serialize_object
from taggit.managers import TaggableManager

__all__ = (
    'ChangeLoggingMixin',
)

from utilities.views import register_model_view


class ChangeLoggingMixin(models.Model):
    """
    Provides change logging support for a model. Adds the `created` and `last_updated` fields.
    """
    created = models.DateTimeField(
        auto_now_add=True,
        blank=True,
        null=True
    )
    last_updated = models.DateTimeField(
        auto_now=True,
        blank=True,
        null=True
    )

    class Meta:
        abstract = True

    def serialize_object(self):
        """
        Return a JSON representation of the instance. Models can override this method to replace or extend the default
        serialization logic provided by the `serialize_object()` utility function.
        """
        return serialize_object(self)

    def snapshot(self):
        """
        Save a snapshot of the object's current state in preparation for modification. The snapshot is saved as
        `_prechange_snapshot` on the instance.
        """
        self._prechange_snapshot = self.serialize_object()

    def to_objectchange(self, action):
        """
        Return a new ObjectChange representing a change made to this object. This will typically be called automatically
        by ChangeLoggingMiddleware.
        """
        from extras.models import ObjectChange
        objectchange = ObjectChange(
            changed_object=self,
            object_repr=str(self)[:200],
            action=action
        )
        if hasattr(self, '_prechange_snapshot'):
            objectchange.prechange_data = self._prechange_snapshot
        if action in (ObjectChangeActionChoices.ACTION_CREATE, ObjectChangeActionChoices.ACTION_UPDATE):
            objectchange.postchange_data = self.serialize_object()

        return objectchange


FEATURES_MAP = ()


@receiver(class_prepared)
def _register_features(sender, **kwargs):
    features = {
        feature for feature, cls in FEATURES_MAP if issubclass(sender, cls)
    }
    register_features(sender, features)

    if issubclass(sender, ChangeLoggingMixin):
        register_model_view(
            sender,
            'changelog',
            'statuspage.views.generic.ObjectChangeLogView',
            kwargs={'model': sender}
        )
