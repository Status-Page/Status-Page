from django import forms

from components.models import Component, ComponentGroup
from components.choices import ComponentStatusChoices, ComponentGroupCollapseChoices
from utilities.forms import FilterForm, StaticSelect, add_blank_choice, \
    BOOLEAN_WITH_BLANK_CHOICES

__all__ = (
    'ComponentGroupFilterForm',
    'ComponentFilterForm',
)


class ComponentGroupFilterForm(FilterForm):
    model = ComponentGroup
    fieldsets = (
        (None, ('q',)),
        ('Component Group', ('name', 'description', 'visibility', 'order', 'collapse')),
    )
    name = forms.CharField(
        required=False,
    )
    description = forms.CharField(
        required=False,
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    order = forms.IntegerField(
        required=False,
    )
    collapse = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(ComponentGroupCollapseChoices),
        widget=StaticSelect(),
    )


class ComponentFilterForm(FilterForm):
    model = Component
    fieldsets = (
        (None, ('q',)),
        ('Component', ('name', 'link', 'description', 'visibility', 'status', 'order')),
    )
    name = forms.CharField(
        required=False,
    )
    link = forms.CharField(
        required=False,
    )
    description = forms.CharField(
        required=False,
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=StaticSelect(
            choices=BOOLEAN_WITH_BLANK_CHOICES,
        ),
    )
    status = forms.ChoiceField(
        required=False,
        choices=add_blank_choice(ComponentStatusChoices),
        widget=StaticSelect(),
    )
    order = forms.IntegerField(
        required=False,
    )
    component_group = forms.ModelChoiceField(
        required=False,
        queryset=ComponentGroup.objects.all(),
        widget=StaticSelect(),
    )
