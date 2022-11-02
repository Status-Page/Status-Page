from django.utils import timezone
from django import template

from components.choices import ComponentStatusChoices
from metrics.choices import MetricRangeChoices

register = template.Library()


@register.inclusion_tag('builtins/tag.html')
def tag(value, viewname=None):
    """
    Display a tag, optionally linked to a filtered list of objects.
    Args:
        value: A Tag instance
        viewname: If provided, the tag will be a hyperlink to the specified view's URL
    """
    return {
        'tag': value,
        'viewname': viewname,
    }


@register.inclusion_tag('builtins/badge.html')
def badge(value, bg_color=None, show_empty=False):
    """
    Display the specified number as a badge.
    Args:
        value: The value to be displayed within the badge
        bg_color: Background color CSS name
        show_empty: If true, display the badge even if value is None or zero
    """
    return {
        'value': value,
        'bg_color': bg_color or 'bg-gray-500',
        'show_empty': show_empty,
    }


@register.inclusion_tag('builtins/checkmark.html')
def checkmark(value, show_false=True, true='Yes', false='No'):
    """
    Display either a green checkmark or red X to indicate a boolean value.
    Args:
        value: True or False
        show_false: Show false values
        true: Text label for true values
        false: Text label for false values
    """
    return {
        'value': bool(value),
        'show_false': show_false,
        'true_label': true,
        'false_label': false,
    }


@register.inclusion_tag('builtins/metric.html')
def metric(metric, range):
    match range:
        case MetricRangeChoices.MINUTES_30:
            datenow_end = timezone.now().replace(microsecond=0, second=59)
            datenow = timezone.now().replace(microsecond=0, second=0)
            daterange = datenow - timezone.timedelta(minutes=30)
        case MetricRangeChoices.HOURS_1:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0)
            daterange = datenow - timezone.timedelta(hours=1)
        case MetricRangeChoices.HOURS_12:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0)
            daterange = datenow - timezone.timedelta(hours=12)
        case MetricRangeChoices.DAYS_1:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59, hour=23)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
            daterange = datenow - timezone.timedelta(days=1)
        case MetricRangeChoices.DAYS_2:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59, hour=23)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
            daterange = datenow - timezone.timedelta(days=2)
        case MetricRangeChoices.DAYS_3:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59, hour=23)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
            daterange = datenow - timezone.timedelta(days=3)
        case MetricRangeChoices.DAYS_7:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59, hour=23)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
            daterange = datenow - timezone.timedelta(days=7)
        case MetricRangeChoices.DAYS_30:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59, hour=23)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
            daterange = datenow - timezone.timedelta(days=30)
        case _:
            datenow_end = timezone.now().replace(microsecond=0, second=59, minute=59)
            datenow = timezone.now().replace(microsecond=0, second=0, minute=0)
            daterange = datenow - timezone.timedelta(hours=12)

    labels = metric.get_metric_labels_json(now=datenow_end, range=daterange)
    points = metric.get_metric_points_json(now=datenow_end, range=daterange)

    return {
        'metric': metric,
        'labels': labels,
        'points': points,
    }


@register.inclusion_tag('builtins/componentgroup_status.html')
def componentgroup_status(componentgroup):
    components = componentgroup.components.all()

    operational_components = list(filter(lambda c: c.status == ComponentStatusChoices.OPERATIONAL, components))
    degraded_components = list(filter(lambda c: c.status == ComponentStatusChoices.DEGRADED_PERFORMANCE, components))
    partial_components = list(filter(lambda c: c.status == ComponentStatusChoices.PARTIAL_OUTAGE, components))
    major_components = list(filter(lambda c: c.status == ComponentStatusChoices.MAJOR_OUTAGE, components))
    maintenance_components = list(filter(lambda c: c.status == ComponentStatusChoices.MAINTENANCE, components))

    if len(maintenance_components) > 0:
        text = maintenance_components[0].get_status_display()
        color = maintenance_components[0].get_status_text_color()
    elif len(major_components) > 0:
        text = major_components[0].get_status_display()
        color = major_components[0].get_status_text_color()
    elif len(partial_components) > 0:
        text = partial_components[0].get_status_display()
        color = partial_components[0].get_status_text_color()
    elif len(degraded_components) > 0:
        text = degraded_components[0].get_status_display()
        color = degraded_components[0].get_status_text_color()
    elif len(operational_components) > 0:
        text = operational_components[0].get_status_display()
        color = operational_components[0].get_status_text_color()
    else:
        text = 'Unknown'
        color = 'text-black'

    return {
        'text': text,
        'color': color,
    }
