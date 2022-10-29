from django import template

register = template.Library()


@register.simple_tag(takes_context=True)
def dashboard_link_active(context, *view_names):
    request = context.get('request')
    for view_name in view_names:
        if getattr(request.resolver_match, 'view_name', False) and request.resolver_match.view_name == view_name:
            return 'bg-indigo-700 text-white'
    return 'text-white hover:bg-indigo-500 hover:bg-opacity-75'


@register.simple_tag(takes_context=True)
def dashboard_dropdown_active(context, *view_names):
    request = context.get('request')
    for view_name in view_names:
        if getattr(request.resolver_match, 'view_name', False) and request.resolver_match.view_name == view_name:
            return 'bg-gray-100'
    return 'hover:bg-gray-100'
