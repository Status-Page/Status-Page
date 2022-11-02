from django import forms

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
            'email',
        )),
    )

    class Meta:
        model = Subscriber
        fields = (
            'email',
        )


class PublicSubscriberForm(TailwindMixin, forms.Form):
    email = forms.EmailField()


class PublicSubscriberManagementForm(StatusPageModelForm):
    fieldsets = (
        ('Subscriber', (
            'incident_subscriptions', 'component_subscriptions',
        )),
    )

    incident_subscriptions = forms.BooleanField(
        label='Subscribe to Incident Updates',
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
            'incident_subscriptions', 'component_subscriptions',
        )
