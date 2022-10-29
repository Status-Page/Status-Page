from typing import Dict
from django import template
from django.template import Context

from statuspage.navigation_menu import MENUS


register = template.Library()


@register.inclusion_tag("navigation/menu.html", takes_context=True)
def nav(context: Context, **kwargs) -> Dict:
    """
    Render the navigation menu.
    """
    user = context['request'].user
    nav_items = []
    nav_dropdowns = []

    # Construct the navigation menu based upon the current user's permissions
    for menu in MENUS:
        dropdowns = []
        items = []

        for item in menu.items:
            if user.has_perms(item.permissions):
                items.append(item)

        for dropdown in menu.dropdowns:
            local_groups = []
            local_items = []
            for group in dropdown.groups:
                local_group_items = []
                for item in group.items:
                    if user.has_perms(item.permissions):
                        local_group_items.append(item)
                if local_group_items:
                    local_groups.append((group, local_group_items))
            for item in dropdown.items:
                if user.has_perms(item.permissions):
                    local_items.append(item)
            if local_groups or local_items:
                dropdowns.append((dropdown, local_groups, local_items))

        if items:
            nav_items.extend(items)
        if dropdowns:
            nav_dropdowns.extend(dropdowns)

    return {
        "nav_items": nav_items,
        "nav_dropdowns": nav_dropdowns,
        "request": context["request"],
        "mobile": kwargs.get('mobile', False),
    }
