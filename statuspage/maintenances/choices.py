from utilities.choices import ChoiceSet


class MaintenanceStatusChoices(ChoiceSet):
    key = 'Maintenance.status'

    SCHEDULED = 'schedule'
    IN_PROGRESS = 'in_progress'
    VERIFYING = 'verifying'
    COMPLETED = 'completed'

    CHOICES = [
        (SCHEDULED, 'Scheduled'),
        (IN_PROGRESS, 'In Progress'),
        (VERIFYING, 'Verifying'),
        (COMPLETED, 'Completed'),
    ]


class MaintenanceImpactChoices(ChoiceSet):
    key = 'Maintenance.impact'

    MAINTENANCE = 'maintenance'

    CHOICES = [
        (MAINTENANCE, 'Maintenance', ('bg-blue-500', 'border-blue-500', 'text-blue-500')),
    ]
