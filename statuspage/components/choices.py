from utilities.choices import ChoiceSet


class ComponentGroupCollapseChoices(ChoiceSet):
    key = 'ComponentGroup.collapse'

    ON_ISSUE = 'expand_issue'
    ALWAYS = 'expand_always'

    CHOICES = [
        (ON_ISSUE, 'Expand on Issue'),
        (ALWAYS, 'Always Expanded'),
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
        (UNKNOWN, 'Unknown', ('bg-black', 'text-black')),
        (OPERATIONAL, 'Operational', ('bg-green-500', 'text-green-500')),
        (DEGRADED_PERFORMANCE, 'Degraded Performance', ('bg-yellow-500', 'text-yellow-500')),
        (PARTIAL_OUTAGE, 'Partial Outage', ('bg-orange-500', 'text-orange-500')),
        (MAJOR_OUTAGE, 'Major Outage', ('bg-red-500', 'text-red-500')),
        (MAINTENANCE, 'Maintenance', ('bg-blue-500', 'text-blue-500')),
    ]
