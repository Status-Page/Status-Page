from statuspage.forms import StatusPageModelForm
from utilities.forms import StaticSelect
from ..models import ExternalStatusPage, ExternalStatusComponent

__all__ = (
    'ExternalStatusPageForm',
    'ExternalStatusComponentForm',
)


class ExternalStatusPageForm(StatusPageModelForm):
    fieldsets = (
        ('Page', (
            'domain', 'provider',
        )),
    )

    class Meta:
        model = ExternalStatusPage
        fields = (
            'domain', 'provider',
        )
        widgets = {
            'provider': StaticSelect(),
        }


class ExternalStatusComponentForm(StatusPageModelForm):
    fieldsets = (
        ('Page', (
            'component',
        )),
    )

    class Meta:
        model = ExternalStatusComponent
        fields = (
            'component',
        )
        widgets = {
            'component': StaticSelect(),
        }
