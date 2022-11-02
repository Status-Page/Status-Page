from django.conf import settings
from django.core.mail import send_mail as django_send_mail
from django.core.serializers import serialize
import json

from django.http import QueryDict
from mptt.models import MPTTModel
import bleach

from extras.plugins import PluginConfig
from incidents.choices import IncidentImpactChoices
from components.choices import ComponentStatusChoices
from statuspage.config import get_config


def get_viewname(model, action=None, rest_api=False):
    """
    Return the view name for the given model and action, if valid.
    :param model: The model or instance to which the view applies
    :param action: A string indicating the desired action (if any); e.g. "add" or "list"
    :param rest_api: A boolean indicating whether this is a REST API view
    """
    is_plugin = isinstance(model._meta.app_config, PluginConfig)
    app_label = model._meta.app_label
    model_name = model._meta.model_name

    if rest_api:
        if is_plugin:
            viewname = f'plugins-api:{app_label}-api:{model_name}'
        else:
            viewname = f'{app_label}-api:{model_name}'
        # Append the action, if any
        if action:
            viewname = f'{viewname}-{action}'

    else:
        viewname = f'{app_label}:{model_name}'
        # Prepend the plugins namespace if this is a plugin model
        if is_plugin:
            viewname = f'plugins:{viewname}'
        # Append the action, if any
        if action:
            viewname = f'{viewname}_{action}'

    return viewname


def serialize_object(obj, extra=None):
    """
    Return a generic JSON representation of an object using Django's built-in serializer. (This is used for things like
    change logging, not the REST API.) Optionally include a dictionary to supplement the object data. A list of keys
    can be provided to exclude them from the returned dictionary. Private fields (prefaced with an underscore) are
    implicitly excluded.
    """
    json_str = serialize('json', [obj])
    data = json.loads(json_str)[0]['fields']

    # Exclude any MPTTModel fields
    if issubclass(obj.__class__, MPTTModel):
        for field in ['level', 'lft', 'rght', 'tree_id']:
            data.pop(field)

    # Include custom_field_data as "custom_fields"
    if hasattr(obj, 'custom_field_data'):
        data['custom_fields'] = data.pop('custom_field_data')

    # Append any extra data
    if extra is not None:
        data.update(extra)

    # Copy keys to list to avoid 'dictionary changed size during iteration' exception
    for key in list(data):
        # Private fields shouldn't be logged in the object change
        if isinstance(key, str) and key.startswith('_'):
            data.pop(key)

    return data


def flatten_dict(d, prefix='', separator='.'):
    """
    Flatten netsted dictionaries into a single level by joining key names with a separator.
    :param d: The dictionary to be flattened
    :param prefix: Initial prefix (if any)
    :param separator: The character to use when concatenating key names
    """
    ret = {}
    for k, v in d.items():
        key = separator.join([prefix, k]) if prefix else k
        if type(v) is dict:
            ret.update(flatten_dict(v, prefix=key, separator=separator))
        else:
            ret[key] = v
    return ret


def foreground_color(bg_color, dark='000000', light='ffffff'):
    """
    Return the ideal foreground color (dark or light) for a given background color in hexadecimal RGB format.
    :param dark: RBG color code for dark text
    :param light: RBG color code for light text
    """
    THRESHOLD = 150
    bg_color = bg_color.strip('#')
    r, g, b = [int(bg_color[c:c + 2], 16) for c in (0, 2, 4)]
    if r * 0.299 + g * 0.587 + b * 0.114 > THRESHOLD:
        return dark
    else:
        return light


def clean_html(html, schemes):
    """
    Sanitizes HTML based on a whitelist of allowed tags and attributes.
    Also takes a list of allowed URI schemes.
    """

    ALLOWED_TAGS = [
        "div", "pre", "code", "blockquote", "del",
        "hr", "h1", "h2", "h3", "h4", "h5", "h6",
        "ul", "ol", "li", "p", "br",
        "strong", "em", "a", "b", "i", "img",
        "table", "thead", "tbody", "tr", "th", "td",
        "dl", "dt", "dd",
    ]

    ALLOWED_ATTRIBUTES = {
        "div": ['class'],
        "h1": ["id"], "h2": ["id"], "h3": ["id"], "h4": ["id"], "h5": ["id"], "h6": ["id"],
        "a": ["href", "title"],
        "img": ["src", "title", "alt"],
    }

    return bleach.clean(
        html,
        tags=ALLOWED_TAGS,
        attributes=ALLOWED_ATTRIBUTES,
        protocols=schemes
    )


def content_type_name(ct):
    """
    Return a human-friendly ContentType name (e.g. "DCIM > Site").
    """
    try:
        meta = ct.model_class()._meta
        return f'{meta.app_config.verbose_name} > {meta.verbose_name}'
    except AttributeError:
        # Model no longer exists
        return f'{ct.app_label} > {ct.model}'


def content_type_identifier(ct):
    """
    Return a "raw" ContentType identifier string suitable for bulk import/export (e.g. "dcim.site").
    """
    return f'{ct.app_label}.{ct.model}'


def shallow_compare_dict(source_dict, destination_dict, exclude=None):
    """
    Return a new dictionary of the different keys. The values of `destination_dict` are returned. Only the equality of
    the first layer of keys/values is checked. `exclude` is a list or tuple of keys to be ignored.
    """
    difference = {}

    for key in destination_dict:
        if source_dict.get(key) != destination_dict[key]:
            if isinstance(exclude, (list, tuple)) and key in exclude:
                continue
            difference[key] = destination_dict[key]

    return difference


def normalize_querydict(querydict):
    """
    Convert a QueryDict to a normal, mutable dictionary, preserving list values. For example,
        QueryDict('foo=1&bar=2&bar=3&baz=')
    becomes:
        {'foo': '1', 'bar': ['2', '3'], 'baz': ''}
    This function is necessary because QueryDict does not provide any built-in mechanism which preserves multiple
    values.
    """
    return {
        k: v if len(v) > 1 else v[0] for k, v in querydict.lists()
    }


def prepare_cloned_fields(instance):
    """
    Generate a QueryDict comprising attributes from an object's clone() method.
    """
    # Generate the clone attributes from the instance
    if not hasattr(instance, 'clone'):
        return QueryDict(mutable=True)
    attrs = instance.clone()

    # Prepare querydict parameters
    params = []
    for key, value in attrs.items():
        if type(value) in (list, tuple):
            params.extend([(key, v) for v in value])
        elif value not in (False, None):
            params.append((key, value))
        else:
            params.append((key, ''))

    # Return a QueryDict with the parameters
    return QueryDict('&'.join([f'{k}={v}' for k, v in params]), mutable=True)


def get_component_status_from_incident_impact(incident_status: str):
    matrix = {
        IncidentImpactChoices.NONE: ComponentStatusChoices.OPERATIONAL,
        IncidentImpactChoices.MINOR: ComponentStatusChoices.DEGRADED_PERFORMANCE,
        IncidentImpactChoices.MAJOR: ComponentStatusChoices.PARTIAL_OUTAGE,
        IncidentImpactChoices.CRITICAL: ComponentStatusChoices.MAJOR_OUTAGE,
    }
    return matrix.get(incident_status, ComponentStatusChoices.OPERATIONAL)


def dynamic_import(name):
    """
    Dynamically import a class from an absolute path string
    """
    components = name.split('.')
    mod = __import__(components[0])
    for comp in components[1:]:
        mod = getattr(mod, comp)
    return mod


def deepmerge(original, new):
    """
    Deep merge two dictionaries (new into original) and return a new dict
    """
    merged = dict(original)
    for key, val in new.items():
        if key in original and isinstance(original[key], dict) and val and isinstance(val, dict):
            merged[key] = deepmerge(original[key], val)
        else:
            merged[key] = val
    return merged


def dict_to_filter_params(d, prefix=''):
    """
    Translate a dictionary of attributes to a nested set of parameters suitable for QuerySet filtering. For example:

        {
            "name": "Foo",
            "rack": {
                "facility_id": "R101"
            }
        }

    Becomes:

        {
            "name": "Foo",
            "rack__facility_id": "R101"
        }

    And can be employed as filter parameters:

        Device.objects.filter(**dict_to_filter(attrs_dict))
    """
    params = {}
    for key, val in d.items():
        k = prefix + key
        if isinstance(val, dict):
            params.update(dict_to_filter_params(val, k + '__'))
        else:
            params[k] = val
    return params


def send_mail(subject, html_message, message, recipient_list):
    config = get_config()
    django_send_mail(
        subject=f'{settings.EMAIL_SUBJECT_PREFIX}{subject}',
        message=f'{message}',
        html_message=f'{html_message}',
        from_email=f'{config.SITE_TITLE} <{settings.DEFAULT_FROM_EMAIL}>',
        recipient_list=recipient_list,
    )
