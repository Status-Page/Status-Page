from statuspage.forms import StatusPageModelForm
from ..models import Subscriber

__all__ = (
    'SubscriberForm',
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
