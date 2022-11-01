from django.contrib.auth.models import AnonymousUser
from django.contrib.contenttypes.models import ContentType
from django.db.models.signals import post_save
from django.dispatch import receiver

from statuspage.request_context import get_request
from subscribers.models import Subscriber
from .choices import ObjectChangeActionChoices
from .models import ObjectChange, ConfigRevision


#
# Change logging
#


def handle_changed_object(sender, instance, **kwargs):
    """
    Fires when an object is created or updated.
    """
    if not hasattr(instance, 'to_objectchange'):
        return

    request = get_request()
    m2m_changed = False

    # Determine the type of change being made
    if kwargs.get('created'):
        action = ObjectChangeActionChoices.ACTION_CREATE
    elif 'created' in kwargs:
        action = ObjectChangeActionChoices.ACTION_UPDATE
    elif kwargs.get('action') in ['post_add', 'post_remove'] and kwargs['pk_set']:
        # m2m_changed with objects added or removed
        m2m_changed = True
        action = ObjectChangeActionChoices.ACTION_UPDATE
    else:
        return

    # Record an ObjectChange if applicable
    if hasattr(instance, 'to_objectchange'):
        if m2m_changed:
            ObjectChange.objects.filter(
                changed_object_type=ContentType.objects.get_for_model(instance),
                changed_object_id=instance.pk,
                request_id=request.id
            ).update(
                postchange_data=instance.to_objectchange(action).postchange_data
            )
        else:
            objectchange = instance.to_objectchange(action)
            if not isinstance(request.user, AnonymousUser):
                objectchange.user = request.user
            elif isinstance(instance, Subscriber):
                objectchange.user_name = instance.email
            else:
                objectchange.user_name = 'anonymous'
            objectchange.request_id = request.id
            objectchange.save()


def handle_deleted_object(sender, instance, **kwargs):
    """
    Fires when an object is deleted.
    """
    if not hasattr(instance, 'to_objectchange'):
        return

    request = get_request()

    # Record an ObjectChange if applicable
    if hasattr(instance, 'to_objectchange'):
        objectchange = instance.to_objectchange(ObjectChangeActionChoices.ACTION_DELETE)
        if not isinstance(request.user, AnonymousUser):
            objectchange.user = request.user
        elif isinstance(instance, Subscriber):
            objectchange.user_name = instance.email
        else:
            objectchange.user_name = 'anonymous'
        objectchange.request_id = request.id
        objectchange.save()


@receiver(post_save, sender=ConfigRevision)
def update_config(sender, instance, **kwargs):
    """
    Update the cached Status-Page configuration when a new ConfigRevision is created.
    """
    instance.activate()
