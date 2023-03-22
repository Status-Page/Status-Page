from django.db.models.signals import post_save
from django.dispatch import receiver

from incidents.models import Incident, IncidentUpdate
from subscribers.models import Subscriber
from utilities.utils import on_transaction_commit, get_mail_domain


@receiver(post_save, sender=Incident)
@on_transaction_commit
def send_notifications(sender, instance: Incident, **kwargs):
    is_new = kwargs.get('created', False)

    if is_new and instance.visibility:
        try:
            subscribers = Subscriber.objects.filter(incident_subscriptions=True)

            for subscriber in subscribers:
                if subscriber.incident_notifications_subscribed_only and len(instance.components.filter(subscribers__in=[subscriber])) == 0:
                    continue
                subscriber.send_mail(subject=f'Incident - {instance.title}', template='incidents/created', context={
                    'incident': instance,
                    'components': instance.components.filter(visibility=True),
                }, headers={
                    'Message-ID': f'incident-{instance.id}-0@{get_mail_domain()}',
                })
        except:
            pass


@receiver(post_save, sender=IncidentUpdate)
@on_transaction_commit
def send_notifications(sender, instance: IncidentUpdate, **kwargs):
    is_new = kwargs.get('created', False)

    if is_new and instance.incident.visibility:
        try:
            subscribers = Subscriber.objects.filter(incident_subscriptions=True)
            message_id = f'incident-{instance.incident.id}-{instance.id}@{get_mail_domain()}'
            previous_message_ids = [
                f'incident-{instance.incident.id}-0@{get_mail_domain()}',
                *list(map(
                    lambda update: f'incident-{instance.incident.id}-{update.id}@{get_mail_domain()}',
                    instance.incident.updates.all()
                ))
            ]

            for subscriber in subscribers:
                if subscriber.incident_notifications_subscribed_only and len(instance.incident.components.filter(subscribers__in=[subscriber])) == 0:
                    continue
                subscriber.send_mail(subject=f'Incident - {instance.incident.title}', template='incidentupdates/created', context={
                    'incident': instance.incident,
                    'update': instance,
                    'components': instance.incident.components.filter(visibility=True),
                }, headers={
                    'Message-ID': message_id,
                    'References': ' '.join(previous_message_ids),
                })
        except:
            pass
