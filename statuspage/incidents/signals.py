import logging

from django.db.models.signals import post_save
from django.dispatch import receiver

from incidents.models import Incident, IncidentUpdate
from subscribers.models import Subscriber
from utilities.utils import on_transaction_commit, get_mail_domain


@receiver(post_save, sender=Incident)
@on_transaction_commit
def send_incident_notifications(sender, instance: Incident, **kwargs):
    logger = logging.getLogger('statuspage.incidents.signals')
    is_new = kwargs.get('created', False)

    if is_new and instance.visibility and instance.send_email:
        subscribers = Subscriber.objects.filter(incident_subscriptions=True)
        update = instance.updates.first()

        for subscriber in subscribers:
            try:
                if subscriber.incident_notifications_subscribed_only and len(instance.components.filter(subscribers__in=[subscriber])) == 0:
                    continue
                subscriber.send_mail(subject=f'Incident - {instance.title}', template='incidents/created', context={
                    'incident': instance,
                    'update': update,
                    'components': instance.components.filter(visibility=True),
                }, headers={
                    'Message-ID': f'<incident-{instance.id}-0-{subscriber.id}@{get_mail_domain()}>',
                })
            except Exception as e:
                logger.error(e)
                pass


@receiver(post_save, sender=IncidentUpdate)
@on_transaction_commit
def send_incident_update_notifications(sender, instance: IncidentUpdate, **kwargs):
    logger = logging.getLogger('statuspage.incidents.signals')
    is_new = kwargs.get('created', False)
    first_update = instance.created == instance.incident.created

    if is_new and instance.incident.visibility and instance.send_email and not first_update:
        subscribers = Subscriber.objects.filter(incident_subscriptions=True)

        for subscriber in subscribers:
            message_id = f'<incident-{instance.incident.id}-{instance.id}-{subscriber.id}@{get_mail_domain()}>'
            previous_message_ids = [
                f'<incident-{instance.incident.id}-0-{subscriber.id}@{get_mail_domain()}>',
                *list(map(
                    lambda update: f'<incident-{instance.incident.id}-{update.id}-{subscriber.id}@{get_mail_domain()}>',
                    instance.incident.updates.all()
                ))
            ]

            try:
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
            except Exception as e:
                logger.error(e)
                pass
