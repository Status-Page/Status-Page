import json

from django import forms
from django.forms.fields import JSONField as _JSONField, InvalidJSONInput
from django.templatetags.static import static

from utilities.forms import widgets
from utilities.validators import EnhancedURLValidator

__all__ = (
    'ChoiceField',
    'ColorField',
    'CommentField',
    'JSONField',
    'LaxURLField',
    'MultipleChoiceField',
)


class CommentField(forms.CharField):
    """
    A textarea with support for Markdown rendering. Exists mostly just to add a standard `help_text`.
    """
    widget = forms.Textarea
    help_text = f"""
        <i class="mdi mdi-information-outline"></i>
        <a href="{static('docs/reference/markdown/')}" target="_blank" tabindex="-1">
        Markdown</a> syntax is supported
    """

    def __init__(self, *, label='', help_text=help_text, required=False, **kwargs):
        super().__init__(label=label, help_text=help_text, required=required, **kwargs)


class ColorField(forms.CharField):
    """
    A field which represents a color value in hexadecimal `RRGGBB` format. Utilizes StatusPage's `ColorSelect` widget to
    render choices.
    """
    widget = widgets.ColorSelect


class LaxURLField(forms.URLField):
    """
    Modifies Django's built-in URLField to remove the requirement for fully-qualified domain names
    (e.g. http://myserver/ is valid)
    """
    default_validators = [EnhancedURLValidator()]


class JSONField(_JSONField):
    """
    Custom wrapper around Django's built-in JSONField to avoid presenting "null" as the default text.
    """
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        if not self.help_text:
            self.help_text = 'Enter context data in <a href="https://json.org/">JSON</a> format.'
            self.widget.attrs['placeholder'] = ''
            self.widget.attrs['class'] = 'font-monospace'

    def prepare_value(self, value):
        if isinstance(value, InvalidJSONInput):
            return value
        if value is None:
            return ''
        return json.dumps(value, sort_keys=True, indent=4)


#
# Choice fields
#

class ChoiceField(forms.ChoiceField):
    """
    Overrides Django's built-in `ChoiceField` to use StatusPage's `StaticSelect` widget
    """
    widget = widgets.StaticSelect


class MultipleChoiceField(forms.MultipleChoiceField):
    """
    Overrides Django's built-in `MultipleChoiceField` to use StatusPage's `StaticSelectMultiple` widget
    """
    widget = widgets.StaticSelectMultiple
