import uuid

from django.conf import settings
from django.db import models
from django.template.loader import render_to_string
from django.urls import reverse

from statuspage.config import get_config
from statuspage.models import StatusPageModel
from components.models import Component
import django_rq

from utilities.utils import send_mail


class Subscriber(StatusPageModel):
    email = models.EmailField()
    email_verified_at = models.DateTimeField(
        blank=True,
        null=True,
    )
    management_key = models.CharField(
        max_length=255,
        blank=True,
        null=True,
    )
    incident_subscriptions = models.BooleanField(
        default=True,
    )
    component_subscriptions = models.ManyToManyField(
        to=Component,
        related_name='subscribers',
        blank=True,
    )

    class Meta:
        ordering = ['pk']

    def __str__(self):
        return self.email

    def get_absolute_url(self):
        return reverse('subscribers:subscriber', args=[self.pk])

    def save(self, *args, **kwargs):
        is_new = self.pk is None

        if is_new:
            self.management_key = uuid.uuid4()

        super().save(*args, **kwargs)

        if is_new:
            components = Component.objects.all()
            for component in components:
                self.component_subscriptions.add(component)

            django_rq.enqueue(send_subscriber_verify_mail, self)

    @classmethod
    def get_by_management_key(cls, management_key):
        try:
            return cls.objects.get(management_key=management_key)
        except:
            return None


def send_subscriber_verify_mail(subscriber):
    config = get_config()
    context = ({
        'site_url': f'{settings.SITE_URL}',
        'site_title': f'{config.SITE_TITLE}',
        'verification_url': settings.SITE_URL + reverse('subscriber_verify', kwargs={'management_key': subscriber.management_key}),
        'management_url': settings.SITE_URL + reverse('subscriber_manage', kwargs={'management_key': subscriber.management_key}),
        'unsubscribe_url': settings.SITE_URL + reverse('subscriber_unsubscribe', kwargs={'management_key': subscriber.management_key}),
    })

    message = render_to_string('subscribers/verification.txt', context)
    html_message = render_to_string('subscribers/verification.html', context)

    send_mail(
        subject=f'Verify your Subscription to {config.SITE_TITLE}',
        message=message,
        html_message=html_message,
        recipient_list=[subscriber.email],
    )
