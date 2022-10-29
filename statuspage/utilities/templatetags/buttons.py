from django import template
from django.urls import NoReverseMatch, reverse

from utilities.utils import get_viewname, prepare_cloned_fields

register = template.Library()


#
# Instance buttons
#

@register.inclusion_tag('buttons/clone.html')
def clone_button(instance):
    url = reverse(get_viewname(instance, 'add'))

    # Populate cloned field values
    param_string = prepare_cloned_fields(instance).urlencode()
    if param_string:
        url = f'{url}?{param_string}'

    return {
        'url': url,
    }


@register.inclusion_tag('buttons/edit.html')
def edit_button(instance):
    viewname = get_viewname(instance, 'edit')
    url = reverse(viewname, kwargs={'pk': instance.pk})

    return {
        'url': url,
    }


@register.inclusion_tag('buttons/delete.html')
def delete_button(instance):
    viewname = get_viewname(instance, 'delete')
    url = reverse(viewname, kwargs={'pk': instance.pk})

    return {
        'url': url,
    }


#
# List buttons
#

@register.inclusion_tag('buttons/add.html')
def add_button(model, action='add'):
    try:
        url = reverse(get_viewname(model, action))
    except NoReverseMatch:
        url = None

    return {
        'url': url,
    }


@register.inclusion_tag('buttons/import.html')
def import_button(model, action='import'):
    try:
        url = reverse(get_viewname(model, action))
    except NoReverseMatch:
        url = None

    return {
        'url': url,
    }


@register.inclusion_tag('buttons/bulk_edit.html')
def bulk_edit_button(model, action='bulk_edit', query_params=None):
    try:
        url = reverse(get_viewname(model, action))
        if query_params:
            url = f'{url}?{query_params.urlencode()}'
    except NoReverseMatch:
        url = None

    return {
        'url': url,
    }


@register.inclusion_tag('buttons/bulk_delete.html')
def bulk_delete_button(model, action='bulk_delete', query_params=None):
    try:
        url = reverse(get_viewname(model, action))
        if query_params:
            url = f'{url}?{query_params.urlencode()}'
    except NoReverseMatch:
        url = None

    return {
        'url': url,
    }
