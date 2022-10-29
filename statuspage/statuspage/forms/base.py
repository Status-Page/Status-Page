from django import forms
from django.contrib.contenttypes.models import ContentType

from utilities.forms import TailwindMixin

__all__ = (
    'StatusPageModelForm',
    'StatusPageModelBulkEditForm',
)


class StatusPageModelForm(TailwindMixin, forms.ModelForm):
    """
    Base form for creating & editing StatusPage models. Extends Django's ModelForm to add support for custom fields.
    Attributes:
        fieldsets: An iterable of two-tuples which define a heading and field set to display per section of
            the rendered form (optional). If not defined, the all fields will be rendered as a single section.
    """
    fieldsets = ()

    def _get_content_type(self):
        return ContentType.objects.get_for_model(self._meta.model)

    def _get_form_field(self, customfield):
        if self.instance.pk:
            form_field = customfield.to_form_field(set_initial=False)
            form_field.initial = self.instance.custom_field_data.get(customfield.name, None)
            return form_field

        return customfield.to_form_field()

    def clean(self):
        return super().clean()


class StatusPageModelBulkEditForm(TailwindMixin, forms.Form):
    """
    Base form for modifying multiple StatusPage objects (of the same type) in bulk via the UI. Adds support for custom
    fields and adding/removing tags.
    Attributes:
        fieldsets: An iterable of two-tuples which define a heading and field set to display per section of
            the rendered form (optional). If not defined, the all fields will be rendered as a single section.
        nullable_fields: A list of field names indicating which fields support being set to null/empty
    """
    nullable_fields = ()

    pk = forms.ModelMultipleChoiceField(
        queryset=None,  # Set from self.model on init
        widget=forms.MultipleHiddenInput
    )

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)

        self.fields['pk'].queryset = self.model.objects.all()

    def _get_form_field(self, customfield):
        return customfield.to_form_field(set_initial=False, enforce_required=False)
