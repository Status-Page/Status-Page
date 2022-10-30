from dataclasses import dataclass
from typing import Sequence, Optional

from extras.registry import registry

#
# Nav menu data classes
#


@dataclass
class MenuItem:
    link: str
    link_text: str
    permissions: Optional[Sequence[str]] = ()


@dataclass
class MenuGroup:
    label: str
    items: Sequence[MenuItem]


@dataclass
class MenuDropdown:
    label: str
    groups: Sequence[MenuGroup]
    items: Sequence[MenuItem]


@dataclass
class Menu:
    items: Sequence[MenuItem]
    dropdowns: Sequence[MenuDropdown]


def get_model_item(app_label, model_name, label):
    return MenuItem(
        link=f'{app_label}:{model_name}_list',
        link_text=label,
        permissions=[f'{app_label}.view_{model_name}'],
    )


def get_past_model_item(app_label, model_name, label):
    return MenuItem(
        link=f'{app_label}:past',
        link_text=label,
        permissions=[f'{app_label}.view_{model_name}'],
    )


#
# Nav menus
#

DEFAULT_MENU = Menu(
    items=(
        MenuItem(
            link='dashboard',
            link_text='Dashboard',
        ),
    ),
    dropdowns=(
        MenuDropdown(
            label='Incidents',
            groups=(),
            items=(
                get_model_item('incidents', 'incident', 'Incidents'),
                get_past_model_item('incidents', 'incident', 'Past'),
            ),
        ),
        MenuDropdown(
            label='Maintenances',
            groups=(),
            items=(
                get_model_item('maintenances', 'maintenance', 'Maintenances'),
                get_past_model_item('maintenances', 'maintenance', 'Past'),
            ),
        ),
        MenuDropdown(
            label='Components',
            groups=(),
            items=(
                get_model_item('components', 'componentgroup', 'Groups'),
                get_model_item('components', 'component', 'Components'),
            ),
        ),
        MenuDropdown(
            label='Metrics',
            groups=(),
            items=(
                get_model_item('metrics', 'metric', 'Metrics'),
            ),
        ),
    ),
)


MENUS = [
    DEFAULT_MENU,
]

#
# Add plugin menus
#

if registry['plugins']['menu_items']:
    plugin_menu_groups = []

    for plugin_name, items in registry['plugins']['menu_items'].items():
        plugin_menu_groups.append(
            MenuGroup(
                label=plugin_name,
                items=items
            )
        )

    PLUGIN_MENU = Menu(
        dropdowns=(
            MenuDropdown(
                label='Plugins',
                items=(),
                groups=plugin_menu_groups,
            ),
        ),
        items=(),
    )

    MENUS.append(PLUGIN_MENU)
