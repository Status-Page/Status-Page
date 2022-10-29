from statuspage.forms import StatusPageModelForm
from utilities.forms import StaticSelect
from ..models import Component, ComponentGroup

__all__ = (
    'ComponentForm',
    'ComponentGroupForm',
)


class ComponentForm(StatusPageModelForm):
    fieldsets = (
        ('Component', (
            'name', 'link', 'description', 'component_group', 'status', 'visibility', 'order',
        )),
    )

    class Meta:
        model = Component
        fields = (
            'name', 'link', 'description', 'component_group', 'status', 'visibility', 'order'
        )
        widgets = {
            'component_group': StaticSelect(),
            'status': StaticSelect(),
        }


class ComponentGroupForm(StatusPageModelForm):
    fieldsets = (
        ('Component Group', (
            'name', 'description', 'visibility', 'order', 'collapse'
        )),
    )

    class Meta:
        model = ComponentGroup
        fields = (
            'name', 'description', 'visibility', 'order', 'collapse'
        )
        widgets = {
            'collapse': StaticSelect(),
        }
