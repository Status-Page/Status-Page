from django import forms

from .widgets import APISelect, APISelectMultiple, ClearableFileInput, StaticSelect


__all__ = (
    'TailwindMixin',
    'FilterForm',
    'ReturnURLForm',
    'ConfirmationForm',
)


class TailwindMixin:
    """
    Add the base Tailwind CSS classes to form elements.
    """

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)

        exempt_widgets = [
            forms.CheckboxInput,
            forms.FileInput,
            forms.RadioSelect,
            forms.Select,
            APISelect,
            APISelectMultiple,
            ClearableFileInput,
            StaticSelect,
        ]

        for field_name, field in self.fields.items():

            if field.widget.__class__ not in exempt_widgets:
                css = field.widget.attrs.get('class', '')
                field.widget.attrs['class'] = ' '.join([css, 'block w-full rounded-md border-gray-300 shadow-sm '
                                                             'sm:text-sm text-black dark:text-white dark:bg-zinc-900'
                                                             ' dark:border-zinc-700']).strip()

            if field.required and not isinstance(field.widget, forms.FileInput):
                field.widget.attrs['required'] = 'required'

            if 'placeholder' not in field.widget.attrs and field.label is not None:
                field.widget.attrs['placeholder'] = field.label

            if field.widget.__class__ == forms.CheckboxInput:
                css = field.widget.attrs.get('class', '')
                field.widget.attrs['class'] = ' '.join((css, 'h-4 w-4 rounded border-gray-300 text-indigo-600'
                                                             ' dark:bg-zinc-900 dark:border-zinc-700')).strip()

            if field.widget.__class__ == forms.Select:
                css = field.widget.attrs.get('class', '')
                field.widget.attrs['class'] = ' '.join((css, 'text-black')).strip()


class FilterForm(TailwindMixin, forms.Form):
    """
    Base Form class for FilterSet forms.
    """
    q = forms.CharField(
        required=False,
        label='Search'
    )


class ReturnURLForm(forms.Form):
    """
    Provides a hidden return URL field to control where the user is directed after the form is submitted.
    """
    return_url = forms.CharField(required=False, widget=forms.HiddenInput())


class ConfirmationForm(TailwindMixin, ReturnURLForm):
    """
    A generic confirmation form. The form is not valid unless the confirm field is checked.
    """
    confirm = forms.BooleanField(required=True, widget=forms.HiddenInput(), initial=True)


class TableConfigForm(TailwindMixin, forms.Form):
    """
    Form for configuring user's table preferences.
    """
    available_columns = forms.MultipleChoiceField(
        choices=[],
        required=False,
        widget=forms.SelectMultiple(
            attrs={'size': 10}
        ),
        label='Available Columns'
    )
    columns = forms.MultipleChoiceField(
        choices=[],
        required=False,
        widget=forms.SelectMultiple(
            attrs={'size': 10}
        ),
        label='Selected Columns'
    )

    def __init__(self, table, *args, **kwargs):
        self.table = table

        super().__init__(*args, **kwargs)

        # Initialize columns field based on table attributes
        self.fields['available_columns'].choices = table.available_columns
        self.fields['columns'].choices = table.selected_columns

    @property
    def table_name(self):
        return self.table.__class__.__name__
