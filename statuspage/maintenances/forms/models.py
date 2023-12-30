from django import forms

from statuspage.context import current_request
from statuspage.forms import StatusPageModelForm
from utilities.forms import StaticSelect, StaticSelectMultiple, DateTimePicker, TailwindMixin
from ..models import Maintenance, MaintenanceUpdate, MaintenanceTemplate
from utilities.forms.fields import fields

__all__ = (
    'MaintenanceForm',
    'MaintenanceTemplateSelectForm',
    'MaintenanceUpdateForm',
    'MaintenanceTemplateForm',
)


class MaintenanceForm(StatusPageModelForm):
    fieldsets = (
        ('Maintenance', (
            'title', 'status', 'impact', 'visibility', 'scheduled_at', 'start_automatically', 'end_at',
            'end_automatically', 'components', 'created',
        )),
        ('Maintenance Update', (
            'send_email', 'text',
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
            'end_automatically', 'components', 'created', 'send_email',
        )
        widgets = {
            'status': StaticSelect(),
            'impact': StaticSelect(),
            'scheduled_at': DateTimePicker(),
            'end_at': DateTimePicker(),
            'components': StaticSelectMultiple(),
            'created': DateTimePicker(),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._newly_created = not self.instance.pk

        if not self.instance.pk:
            self.fields['text'].required = True

    def save(self, *args, **kwargs):
        request = current_request.get()

        self.instance.user = request.user
        maintenance = super().save(*args, **kwargs)

        maintenance_update_text = self.cleaned_data.get("text")
        if maintenance_update_text is not None and not maintenance_update_text == "":
            update = MaintenanceUpdate()
            update.maintenance = maintenance
            update.text = maintenance_update_text
            if self._newly_created:
                update.new_status = True
                update.created = maintenance.created
            else:
                update.new_status = 'status' in self.changed_data
            update.send_email = maintenance.send_email
            update.status = maintenance.status
            update.user = request.user
            update.save()

        return maintenance


class MaintenanceTemplateSelectForm(TailwindMixin, forms.Form):
    template = forms.ModelChoiceField(
        queryset=MaintenanceTemplate.objects.all(),
        widget=StaticSelect(),
        label='',
        required=False,
    )


class MaintenanceUpdateForm(StatusPageModelForm):
    fieldsets = (
        ('Maintenance Update', (
            'text', 'new_status', 'status', 'created',
        )),
    )

    text = fields.CommentField(
        label='Text',
    )

    class Meta:
        model = MaintenanceUpdate
        fields = (
            'text', 'new_status', 'status', 'created',
        )
        widgets = {
            'status': StaticSelect(),
            'created': DateTimePicker(),
        }


class MaintenanceTemplateForm(StatusPageModelForm):
    fieldsets = (
        ('Maintenance Template', (
            'template_name', 'title', 'status', 'impact', 'visibility', 'start_automatically', 'end_automatically',
            'components',
        )),
        ('Maintenance Update', (
            'update_component_status', 'text',
        )),
    )

    text = fields.CommentField(
        label='Text',
    )

    class Meta:
        model = MaintenanceTemplate
        fields = (
            'template_name', 'title', 'status', 'impact', 'visibility', 'start_automatically', 'end_automatically',
            'components', 'update_component_status', 'text',
        )
        widgets = {
            'status': StaticSelect(),
            'impact': StaticSelect(),
            'components': StaticSelectMultiple(),
            'created': DateTimePicker(),
        }
