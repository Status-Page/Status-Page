from django.contrib.contenttypes.models import ContentType

from statuspage.request_context import get_request
from .choices import ObjectChangeActionChoices
from .models import ObjectChange

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

    def is_same_object(instance, webhook_data):
        return (
            ContentType.objects.get_for_model(instance) == webhook_data['content_type'] and
            instance.pk == webhook_data['object_id'] and
            request.id == webhook_data['request_id']
        )

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
            objectchange.user = request.user
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
        objectchange.user = request.user
        objectchange.request_id = request.id
        objectchange.save()
