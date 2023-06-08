from django import forms

from .widgets import APISelect, APISelectMultiple, ClearableFileInput, StaticSelect


__all__ = (
    'TailwindMixin',
    'FilterForm',
    'ReturnURLForm',
    'ConfirmationForm',
    'TableConfigForm',
    'BulkEditForm',
    'CSVModelForm',
)


class TailwindMixin:
    """
    Add the base Tailwind CSS classes to form elements.
    """

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)

        exempt_widgets = [
            forms.FileInput,
            forms.RadioSelect,
            APISelect,
            APISelectMultiple,
            ClearableFileInput,
            StaticSelect,
        ]

        for field_name, field in self.fields.items():
            css = field.widget.attrs.get('class', '')

            if field.widget.__class__ in exempt_widgets:
                continue
            elif isinstance(field.widget, forms.CheckboxInput):
                field.widget.attrs['class'] = f'{css} h-4 w-4 rounded border-gray-300 text-indigo-600 ' \
                                              f'dark:bg-zinc-900 dark:border-zinc-700'
            elif isinstance(field.widget, forms.SelectMultiple) and 'size' in field.widget.attrs:
                # Use native Bootstrap class for multi-line <select> widgets
                field.widget.attrs['class'] = f'{css} block w-full rounded-md border-gray-300 shadow-sm sm:text-sm ' \
                                              f'text-black dark:text-white dark:bg-zinc-900 dark:border-zinc-700'
            elif isinstance(field.widget, (forms.Select, forms.SelectMultiple)):
                field.widget.attrs['class'] = f'{css} statuspage-static-select'
            else:
                field.widget.attrs['class'] = f'{css} block w-full rounded-md border-gray-300 shadow-sm sm:text-sm ' \
                                              f'text-black dark:text-white dark:bg-zinc-900 dark:border-zinc-700'

            if field.required and not isinstance(field.widget, forms.FileInput):
                field.widget.attrs['required'] = 'required'

            if 'placeholder' not in field.widget.attrs and field.label is not None:
                field.widget.attrs['placeholder'] = field.label


class FilterForm(TailwindMixin, forms.Form):
    """
    Base Form class for FilterSet forms.
    """
    q = forms.CharField(
        required=False,
        label='Search'
    )


class BulkEditForm(TailwindMixin, forms.Form):
    """
    Provides bulk edit support for objects.
    """
    nullable_fields = ()


class CSVModelForm(forms.ModelForm):
    """
    ModelForm used for the import of objects in CSV format.
    """
    def __init__(self, *args, headers=None, fields=None, **kwargs):
        headers = headers or {}
        fields = fields or []
        super().__init__(*args, **kwargs)

        # Modify the model form to accommodate any customized to_field_name properties
        for field, to_field in headers.items():
            if to_field is not None:
                self.fields[field].to_field_name = to_field

        # Omit any fields not specified (e.g. because the form is being used to
        # updated rather than create objects)
        if fields:
            for field in list(self.fields.keys()):
                if field not in fields:
                    del self.fields[field]


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
