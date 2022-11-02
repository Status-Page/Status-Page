from utilities.choices import ChoiceSet


class IncidentStatusChoices(ChoiceSet):
    key = 'Incident.status'

    INVESTIGATING = 'investigating'
    IDENTIFIED = 'identified'
    MONITORING = 'monitoring'
    RESOLVED = 'resolved'

    CHOICES = [
        (INVESTIGATING, 'Investigating'),
        (IDENTIFIED, 'Identified'),
        (MONITORING, 'Monitoring'),
        (RESOLVED, 'Resolved'),
    ]


class IncidentImpactChoices(ChoiceSet):
    key = 'Incident.impact'

    NONE = 'none'
    MINOR = 'minor'
    MAJOR = 'major'
    CRITICAL = 'critical'

    CHOICES = [
        (NONE, 'None', ('bg-black', 'border-black', 'text-black')),
        (MINOR, 'Minor', ('bg-yellow-500', 'border-yellow-500', 'text-yellow-500')),
        (MAJOR, 'Major', ('bg-orange-500', 'border-orange-500', 'text-orange-500')),
        (CRITICAL, 'Critical', ('bg-red-500', 'border-red-500', 'text-red-500')),
    ]
