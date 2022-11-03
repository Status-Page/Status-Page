from dataclasses import dataclass
from typing import Optional

import django_tables2 as tables
from django.conf import settings
from django.contrib.auth.models import AnonymousUser
from django.db.models import DateField, DateTimeField
from django.template import Context, Template
from django.urls import reverse
from django.utils.encoding import escape_uri_path
from django.utils.formats import date_format
from django.utils.safestring import mark_safe
from django_tables2.columns import library

from utilities.utils import get_viewname, content_type_name, content_type_identifier

__all__ = (
    'ActionsColumn',
    'BooleanColumn',
    'ChoiceFieldColumn',
    'ColorColumn',
    'ColoredLabelColumn',
    'LinkedCountColumn',
    'ManyToManyColumn',
    'TagColumn',
    'TemplateColumn',
    'ToggleColumn',
    'UtilizationColumn',
)


#
# Django-tables2 overrides
#

@library.register
class DateColumn(tables.DateColumn):
    """
    Overrides the default implementation of DateColumn to better handle null values, returning a default value for
    tables and null when exporting data. It is registered in the tables library to use this class instead of the
    default, making this behavior consistent in all fields of type DateField.
    """
    def value(self, value):
        return value

    @classmethod
    def from_field(cls, field, **kwargs):
        if isinstance(field, DateField):
            return cls(**kwargs)


@library.register
class DateTimeColumn(tables.DateTimeColumn):
    """
    Overrides the default implementation of DateTimeColumn to better handle null values, returning a default value for
    tables and null when exporting data. It is registered in the tables library to use this class instead of the
    default, making this behavior consistent in all fields of type DateTimeField.
    """
    def value(self, value):
        if value:
            return date_format(value, format="SHORT_DATETIME_FORMAT")
        return None

    @classmethod
    def from_field(cls, field, **kwargs):
        if isinstance(field, DateTimeField):
            return cls(**kwargs)


class ManyToManyColumn(tables.ManyToManyColumn):
    """
    Overrides django-tables2's stock ManyToManyColumn to ensure that value() returns only plaintext data.
    """
    def value(self, value):
        items = [self.transform(item) for item in self.filter(value)]
        return self.separator.join(items)


class TemplateColumn(tables.TemplateColumn):
    """
    Overrides django-tables2's stock TemplateColumn class to render a placeholder symbol if the returned value
    is an empty string.
    """
    PLACEHOLDER = mark_safe('&mdash;')

    def __init__(self, export_raw=False, **kwargs):
        """
        Args:
            export_raw: If true, data export returns the raw field value rather than the rendered template. (Default:
                        False)
        """
        super().__init__(**kwargs)
        self.export_raw = export_raw

    def render(self, *args, **kwargs):
        ret = super().render(*args, **kwargs)
        if not ret.strip():
            return self.PLACEHOLDER
        return ret

    def value(self, **kwargs):
        if self.export_raw:
            # Skip template rendering and export raw value
            return kwargs.get('value')

        ret = super().value(**kwargs)
        if ret == self.PLACEHOLDER:
            return ''
        return ret


#
# Custom columns
#

class ToggleColumn(tables.CheckBoxColumn):
    """
    Extend CheckBoxColumn to add a "toggle all" checkbox in the column header.
    """
    def __init__(self, *args, **kwargs):
        default = kwargs.pop('default', '')
        visible = kwargs.pop('visible', False)
        if 'attrs' not in kwargs:
            kwargs['attrs'] = {
                'td': {
                    'class': 'whitespace-nowrap px-3 py-4 text-gray-500',
                },
                'input': {
                    'class': 'h-4 w-4 rounded border-gray-300 text-indigo-600'
                }
            }
        super().__init__(*args, default=default, visible=visible, **kwargs)

    @property
    def header(self):
        return mark_safe('<input type="checkbox" class="toggle h-4 w-4 rounded border-gray-300 text-indigo-600" title="Toggle All" />')


class BooleanColumn(tables.Column):
    """
    Custom implementation of BooleanColumn to render a nicely-formatted checkmark or X icon instead of a Unicode
    character.
    """
    def render(self, value):
        if value:
            rendered = '<span class="text-green-500"><i class="mdi mdi-check-bold"></i></span>'
        elif value is None:
            rendered = '<span class="text-gray-500">&mdash;</span>'
        else:
            rendered = '<span class="text-red-500"><i class="mdi mdi-close-thick"></i></span>'
        return mark_safe(rendered)

    def value(self, value):
        return str(value)


@dataclass
class ActionsItem:
    title: str
    icon: str
    permission: Optional[str] = None
    css_class: Optional[str] = 'bg-zinc-500 hover:bg-zinc-400'


class ActionsColumn(tables.Column):
    """
    A dropdown menu which provides edit, delete, and changelog links for an object. Can optionally include
    additional buttons rendered from a template string.

    :param actions: The ordered list of dropdown menu items to include
    :param extra_buttons: A Django template string which renders additional buttons preceding the actions dropdown
    :param split_actions: When True, converts the actions dropdown menu into a split button with first action as the
        direct button link and icon (default: True)
    """
    attrs = {'td': {'class': 'whitespace-nowrap px-3 py-4 text-right text-black dark:text-gray-200 print:hidden'}}
    empty_values = ()
    actions = {
        'edit': ActionsItem('Edit', 'pencil', 'change', 'bg-yellow-500 hover:bg-yellow-400'),
        'delete': ActionsItem('Delete', 'trash-can-outline', 'delete', 'bg-red-500 hover:bg-red-400'),
        'changelog': ActionsItem('Changelog', 'history'),
    }

    def __init__(self, *args, actions=('edit', 'delete', 'changelog'), extra_buttons='', split_actions=True, **kwargs):
        super().__init__(*args, **kwargs)

        self.extra_buttons = extra_buttons
        self.split_actions = split_actions

        # Determine which actions to enable
        self.actions = {
            name: self.actions[name] for name in actions
        }

    def header(self):
        return ''

    def render(self, record, table, **kwargs):
        # Skip dummy records (e.g. available VLANs) or those with no actions
        if not getattr(record, 'pk', None) or (not self.actions and not self.extra_buttons):
            return ''

        model = table.Meta.model
        request = getattr(table, 'context', {}).get('request')
        url_appendix = f'?return_url={escape_uri_path(request.get_full_path())}' if request else ''
        html = ''

        buttons = []
        user = getattr(request, 'user', AnonymousUser())
        for idx, (action, attrs) in enumerate(self.actions.items()):
            permission = f'{model._meta.app_label}.{attrs.permission}_{model._meta.model_name}'
            if attrs.permission is None or user.has_perm(permission):
                url = reverse(get_viewname(model, action), kwargs={'pk': record.pk})

                buttons.append(
                    f'<a class="px-2 py-1 rounded-md {attrs.css_class}" href="{url}{url_appendix}" type="button">'
                    f'<i class="mdi mdi-{attrs.icon}"></i></a>'
                )

        rendered_extra_buttons = ''

        # Render any extra buttons from template code
        if self.extra_buttons:
            template = Template(self.extra_buttons)
            context = getattr(table, "context", Context())
            context.update({'record': record})
            rendered_extra_buttons = template.render(context) + html

        html += (
            f'<div class="flex flex-row space-x-2 justify-end">'
            f'  {rendered_extra_buttons}'
            f'  {"".join(buttons)}'
            f'</div>'
        )

        return mark_safe(html)


class ChoiceFieldColumn(tables.Column):
    """
    Render a model's static ChoiceField with its value from `get_FOO_display()` as a colored badge. Background color is
    set by the instance's get_FOO_color() method, if defined.
    """
    DEFAULT_BG_COLOR = 'bg-gray-500'

    def render(self, record, bound_column, value):
        if value in self.empty_values:
            return self.default

        # Determine the background color to use (try calling object.get_FOO_color())
        try:
            bg_color = getattr(record, f'get_{bound_column.name}_color')() or self.DEFAULT_BG_COLOR
        except AttributeError:
            bg_color = self.DEFAULT_BG_COLOR

        return mark_safe(f'<span class="inline-flex items-center rounded-full px-3 py-0.5 text-sm text-white font-medium {bg_color}">{value}</span>')

    def value(self, value):
        return value


class ContentTypeColumn(tables.Column):
    """
    Display a ContentType instance.
    """
    def render(self, value):
        if value is None:
            return None
        return content_type_name(value)

    def value(self, value):
        if value is None:
            return None
        return content_type_identifier(value)


class ColorColumn(tables.Column):
    """
    Display an arbitrary color value, specified in RRGGBB format.
    """
    def render(self, value):
        return mark_safe(
            f'<span class="color-label" style="background-color: #{value}">&nbsp;</span>'
        )

    def value(self, value):
        return f'#{value}'


class ColoredLabelColumn(tables.TemplateColumn):
    """
    Render a related object as a colored label. The related object must have a `color` attribute (specifying
    an RRGGBB value) and a `get_absolute_url()` method.
    """
    template_code = """
{% load helpers %}
  {% if value %}
  <span class="badge" style="color: {{ value.color|fgcolor }}; background-color: #{{ value.color }}">
    <a href="{{ value.get_absolute_url }}">{{ value }}</a>
  </span>
{% else %}
  &mdash;
{% endif %}
"""

    def __init__(self, *args, **kwargs):
        super().__init__(template_code=self.template_code, *args, **kwargs)

    def value(self, value):
        return str(value)


class LinkedCountColumn(tables.Column):
    """
    Render a count of related objects linked to a filtered URL.

    :param viewname: The view name to use for URL resolution
    :param view_kwargs: Additional kwargs to pass for URL resolution (optional)
    :param url_params: A dict of query parameters to append to the URL (e.g. ?foo=bar) (optional)
    """
    def __init__(self, viewname, *args, view_kwargs=None, url_params=None, default=0, **kwargs):
        self.viewname = viewname
        self.view_kwargs = view_kwargs or {}
        self.url_params = url_params
        super().__init__(*args, default=default, **kwargs)

    def render(self, record, value):
        if value:
            url = reverse(self.viewname, kwargs=self.view_kwargs)
            if self.url_params:
                url += '?' + '&'.join([
                    f'{k}={getattr(record, v) or settings.FILTERS_NULL_CHOICE_VALUE}'
                    for k, v in self.url_params.items()
                ])
            return mark_safe(f'<a href="{url}">{value}</a>')
        return value

    def value(self, value):
        return value


class TagColumn(tables.TemplateColumn):
    """
    Display a list of Tags assigned to the object.
    """
    template_code = """
    {% load helpers %}
    {% for tag in value.all %}
        {% tag tag url_name %}
    {% empty %}
        <span class="text-gray-400">&mdash;</span>
    {% endfor %}
    """

    def __init__(self, url_name=None):
        super().__init__(
            orderable=False,
            template_code=self.template_code,
            extra_context={'url_name': url_name}
        )

    def value(self, value):
        return ",".join([tag.name for tag in value.all()])


class UtilizationColumn(tables.TemplateColumn):
    """
    Display a colored utilization bar graph.
    """
    template_code = """{% load helpers %}{% if record.pk %}{% utilization_graph value %}{% endif %}"""

    def __init__(self, *args, **kwargs):
        super().__init__(template_code=self.template_code, *args, **kwargs)

    def value(self, value):
        return f'{value}%'


class MarkdownColumn(tables.TemplateColumn):
    """
    Render a Markdown string.
    """
    template_code = """
    {% if value %}
      {{ value|markdown }}
    {% else %}
      &mdash;
    {% endif %}
    """

    def __init__(self):
        super().__init__(
            template_code=self.template_code
        )

    def value(self, value):
        return value
