from utilities.choices import ChoiceSet
from django.utils.translation import gettext_lazy as _


class MaintenanceStatusChoices(ChoiceSet):
    key = 'Maintenance.status'

    SCHEDULED = 'schedule'
    IN_PROGRESS = 'in_progress'
    VERIFYING = 'verifying'
    COMPLETED = 'completed'

    CHOICES = [
        (SCHEDULED, _('Scheduled')),
        (IN_PROGRESS, _('In Progress')),
        (VERIFYING, _('Verifying')),
        (COMPLETED, _('Completed')),
    ]


class MaintenanceImpactChoices(ChoiceSet):
    key = 'Maintenance.impact'

    MAINTENANCE = 'maintenance'

    CHOICES = [
        (MAINTENANCE, _('Maintenance'), ('bg-blue-500', 'border-blue-500', 'text-blue-500')),
    ]
