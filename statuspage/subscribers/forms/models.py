from django import forms
from django.forms import fields
from django.utils import timezone

from components.models import Component
from statuspage.forms import StatusPageModelForm
from utilities.forms import TailwindMixin, StaticSelectMultiple
from ..models import Subscriber

__all__ = (
    'SubscriberForm',
    'PublicSubscriberForm',
    'PublicSubscriberManagementForm',
)


class SubscriberForm(StatusPageModelForm):
    fieldsets = (
        ('Subscriber', (
            'email', 'verification_mail',
        )),
    )

    verification_mail = fields.BooleanField(
        label='Send Verification E-Mail',
        initial=True,
        required=False,
    )

    class Meta:
        model = Subscriber
        fields = (
            'email',
        )

    def save(self, **kwargs):
        if not self.cleaned_data['verification_mail']:
            self.instance.email_verified_at = timezone.now()
        return super().save(**kwargs)


class PublicSubscriberForm(TailwindMixin, forms.Form):
    email = forms.EmailField()


class PublicSubscriberManagementForm(StatusPageModelForm):
    fieldsets = (
        ('Subscriber', (
            'incident_subscriptions', 'incident_notifications_subscribed_only', 'component_subscriptions',
        )),
    )

    incident_subscriptions = forms.BooleanField(
        label='Subscribe to Incident Updates',
        required=False,
    )
    incident_notifications_subscribed_only = forms.BooleanField(
        label='Receive Incident Notifications only for Subscribed Components',
        required=False,
    )
    component_subscriptions = forms.ModelMultipleChoiceField(
        queryset=Component.objects.filter(visibility=True),
        widget=StaticSelectMultiple(),
        label='Subscribed Components',
        required=False,
    )

    class Meta:
        model = Subscriber
        fields = (
            'incident_subscriptions', 'incident_notifications_subscribed_only', 'component_subscriptions',
        )
