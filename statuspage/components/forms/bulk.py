from django import forms

from statuspage.forms import StatusPageModelBulkEditForm
from utilities.forms import StaticSelect, add_blank_choice, BulkEditNullBooleanSelect
from ..models import Component, ComponentGroup
from .. import choices

__all__ = (
    'ComponentGroupBulkEditForm',
    'ComponentBulkEditForm',
)


class ComponentBulkEditForm(StatusPageModelBulkEditForm):
    description = forms.CharField(
        max_length=255,
        required=False,
    )
    link = forms.URLField(
        max_length=255,
        required=False,
    )
    component_group = forms.ModelChoiceField(
        queryset=ComponentGroup.objects.all(),
        required=False,
        widget=StaticSelect(),
        label='Component Group',
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
        label='Visible',
    )
    status = forms.ChoiceField(
        choices=add_blank_choice(choices.ComponentStatusChoices),
        required=False,
        widget=StaticSelect(),
    )
    order = forms.IntegerField(
        required=False,
    )

    model = Component
    fieldsets = (
        ('Component', ('description', 'link', 'component_group', 'visibility', 'status', 'order')),
    )
    nullable_fields = ('link', 'description', 'component_group')


class ComponentGroupBulkEditForm(StatusPageModelBulkEditForm):
    description = forms.CharField(
        max_length=255,
        required=False,
    )
    visibility = forms.NullBooleanField(
        required=False,
        widget=BulkEditNullBooleanSelect,
        label='Visible',
    )
    order = forms.IntegerField(
        required=False,
    )
    collapse = forms.ChoiceField(
        choices=add_blank_choice(choices.ComponentGroupCollapseChoices),
        required=False,
        widget=StaticSelect(),
    )

    model = ComponentGroup
    fieldsets = (
        ('Component', ('description', 'visibility', 'order', 'collapse')),
    )
    nullable_fields = ('link', 'description')
