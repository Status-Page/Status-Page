from statuspage.forms import StatusPageModelForm
from statuspage.request_context import get_request
from utilities.forms import StaticSelect, StaticSelectMultiple, DateTimePicker
from ..models import Maintenance, MaintenanceUpdate
from utilities.forms.fields import fields
from django import forms
from ..choices import MaintenanceStatusChoices
from components.choices import ComponentStatusChoices

__all__ = (
    'MaintenanceForm',
    'MaintenanceUpdateForm',
)


class MaintenanceForm(StatusPageModelForm):
    fieldsets = (
        ('Maintenance', (
            'title', 'status', 'impact', 'visibility', 'scheduled_at', 'start_automatically', 'end_at',
            'end_automatically', 'components',
        )),
        ('Maintenance Update', (
            'text',
        )),
    )

    text = fields.CommentField(
        label='Text',
        required=False,
    )

    class Meta:
        model = Maintenance
        fields = (
            'title', 'status', 'impact', 'visibility', 'scheduled_at', 'start_automatically', 'end_at',
            'end_automatically', 'components',
        )
        widgets = {
            'status': StaticSelect(),
            'impact': StaticSelect(),
            'scheduled_at': DateTimePicker(),
            'end_at': DateTimePicker(),
            'components': StaticSelectMultiple(),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._newly_created = not self.instance.pk

        if not self.instance.pk:
            self.fields['text'].required = True

    def save(self, *args, **kwargs):
        request = get_request()

        self.instance.user = request.user
        maintenance = super().save(*args, **kwargs)

        maintenance_update_text = self.cleaned_data.get("text")
        if maintenance_update_text is not None and not maintenance_update_text == "":
            update = MaintenanceUpdate()
            update.maintenance = maintenance
            update.text = maintenance_update_text
            if self._newly_created:
                update.new_status = True
            else:
                update.new_status = 'status' in self.changed_data
            update.status = maintenance.status
            update.user = request.user
            update.save()

        return maintenance


class MaintenanceUpdateForm(StatusPageModelForm):
    fieldsets = (
        ('Maintenance Update', (
            'text', 'new_status', 'status',
        )),
    )

    class Meta:
        model = MaintenanceUpdate
        fields = (
            'text', 'new_status', 'status',
        )
        widgets = {
            'status': StaticSelect(),
        }
