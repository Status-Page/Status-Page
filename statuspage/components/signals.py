from django.db.models.signals import pre_save
from django.dispatch import receiver

from components.models import Component


@receiver(pre_save, sender=Component)
def send_notifications(sender, instance, **kwargs):
    try:
        old_component = Component.objects.get(pk=instance.pk)
        subscribers = instance.subscribers.all()

        if old_component.status == instance.status or not instance.visibility:
            return None

        for subscriber in subscribers:
            subscriber.send_mail(subject=f'Component "{instance.name}": Status Updated', template='components/update', context={
                'old_component': old_component,
                'component': instance,
            })
    except:
        pass
