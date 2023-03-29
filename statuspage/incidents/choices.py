from utilities.choices import ChoiceSet
from django.utils.translation import gettext_lazy as _


class IncidentStatusChoices(ChoiceSet):
    key = 'Incident.status'

    INVESTIGATING = 'investigating'
    IDENTIFIED = 'identified'
    MONITORING = 'monitoring'
    RESOLVED = 'resolved'

    CHOICES = [
        (INVESTIGATING, _('Investigating')),
        (IDENTIFIED, _('Identified')),
        (MONITORING, _('Monitoring')),
        (RESOLVED, _('Resolved')),
    ]


class IncidentImpactChoices(ChoiceSet):
    key = 'Incident.impact'

    NONE = 'none'
    MINOR = 'minor'
    MAJOR = 'major'
    CRITICAL = 'critical'

    CHOICES = [
        (NONE, _('None'), ('bg-black', 'border-black', 'text-black')),
        (MINOR, _('Minor'), ('bg-yellow-500', 'border-yellow-500', 'text-yellow-500')),
        (MAJOR, _('Major'), ('bg-orange-500', 'border-orange-500', 'text-orange-500')),
        (CRITICAL, _('Critical'), ('bg-red-500', 'border-red-500', 'text-red-500')),
    ]
