from statuspage.forms import StatusPageModelForm
from statuspage.request_context import get_request
from utilities.forms import StaticSelect, StaticSelectMultiple, DateTimePicker, TailwindMixin
from utilities.utils import get_component_status_from_incident_impact
from ..models import Incident, IncidentUpdate, IncidentTemplate
from utilities.forms.fields import fields
from django import forms
from incidents.choices import IncidentStatusChoices
from components.choices import ComponentStatusChoices

__all__ = (
    'IncidentForm',
    'IncidentTemplateSelectForm',
    'IncidentUpdateForm',
    'IncidentTemplateForm',
)


class IncidentForm(StatusPageModelForm):
    fieldsets = (
        ('Incident', (
            'title', 'status', 'impact', 'visibility', 'components', 'created',
        )),
        ('Incident Update', (
            'update_component_status', 'text',
        )),
    )

    text = fields.CommentField(
        label='Text',
        required=False,
    )
    update_component_status = forms.BooleanField(
        label='Update Component Status',
        required=False,
    )

    class Meta:
        model = Incident
        fields = (
            'title', 'status', 'impact', 'visibility', 'components', 'created',
        )
        widgets = {
            'status': StaticSelect(),
            'impact': StaticSelect(),
            'components': StaticSelectMultiple(),
            'created': DateTimePicker(),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._newly_created = not self.instance.pk

        if not self.instance.pk:
            self.fields['text'].required = True

    def save(self, *args, **kwargs):
        request = get_request()

        self.instance.user = request.user
        incident = super().save(*args, **kwargs)

        incident_update_text = self.cleaned_data.get("text")
        update_component_status = self.cleaned_data.get("update_component_status")
        if incident_update_text is not None and not incident_update_text == "":
            update = IncidentUpdate()
            update.incident = incident
            update.text = incident_update_text
            if self._newly_created:
                update.new_status = True
                update.created = incident.created
            else:
                update.new_status = 'status' in self.changed_data
            update.status = incident.status
            update.user = request.user
            update.save()

            if update_component_status:
                if incident.status == IncidentStatusChoices.RESOLVED:
                    incident.components.update(status=ComponentStatusChoices.OPERATIONAL)
                else:
                    incident.components.update(status=get_component_status_from_incident_impact(incident.impact))

        return incident


class IncidentTemplateSelectForm(TailwindMixin, forms.Form):
    template = forms.ModelChoiceField(
        queryset=IncidentTemplate.objects.all(),
        widget=StaticSelect(),
        label='',
        required=False,
    )


class IncidentUpdateForm(StatusPageModelForm):
    fieldsets = (
        ('Incident Update', (
            'text', 'new_status', 'status', 'created',
        )),
    )

    text = fields.CommentField(
        label='Text',
    )

    class Meta:
        model = IncidentUpdate
        fields = (
            'text', 'new_status', 'status', 'created',
        )
        widgets = {
            'status': StaticSelect(),
            'created': DateTimePicker(),
        }


class IncidentTemplateForm(StatusPageModelForm):
    fieldsets = (
        ('Incident Template', (
            'template_name', 'title', 'status', 'impact', 'visibility', 'components',
        )),
        ('Incident Update', (
            'update_component_status', 'text',
        )),
    )

    text = fields.CommentField(
        label='Text',
    )

    class Meta:
        model = IncidentTemplate
        fields = (
            'template_name', 'title', 'status', 'impact', 'visibility', 'components', 'update_component_status', 'text',
        )
        widgets = {
            'status': StaticSelect(),
            'impact': StaticSelect(),
            'components': StaticSelectMultiple(),
            'created': DateTimePicker(),
        }
