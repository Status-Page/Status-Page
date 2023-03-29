from utilities.choices import ChoiceSet
from django.utils.translation import gettext as _


class ComponentGroupCollapseChoices(ChoiceSet):
    key = 'ComponentGroup.collapse'

    ON_ISSUE = 'expand_issue'
    ALWAYS = 'expand_always'

    CHOICES = [
        (ON_ISSUE, _('Expand on Issue')),
        (ALWAYS, _('Always Expanded')),
    ]


class ComponentStatusChoices(ChoiceSet):
    key = 'Component.status'

    UNKNOWN = 'unknown'
    OPERATIONAL = 'operational'
    DEGRADED_PERFORMANCE = 'degraded_performance'
    PARTIAL_OUTAGE = 'partial_outage'
    MAJOR_OUTAGE = 'major_outage'
    MAINTENANCE = 'maintenance'

    CHOICES = [
        (UNKNOWN, _('Unknown'), ('bg-black', 'text-black')),
        (OPERATIONAL, _('Operational'), ('bg-green-500', 'text-green-500')),
        (DEGRADED_PERFORMANCE, _('Degraded Performance'), ('bg-yellow-500', 'text-yellow-500')),
        (PARTIAL_OUTAGE, _('Partial Outage'), ('bg-orange-500', 'text-orange-500')),
        (MAJOR_OUTAGE, _('Major Outage'), ('bg-red-500', 'text-red-500')),
        (MAINTENANCE, _('Maintenance'), ('bg-blue-500', 'text-blue-500')),
    ]
