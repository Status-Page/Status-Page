from statuspage.forms import StatusPageModelForm
from utilities.forms import StaticSelect
from ..models import UptimeRobotMonitor

__all__ = (
    'UptimeRobotMonitorForm',
)


class UptimeRobotMonitorForm(StatusPageModelForm):
    fieldsets = (
        ('UptimeRobot Monitor', (
            'component', 'metric', 'paused',
        )),
    )

    class Meta:
        model = UptimeRobotMonitor
        fields = (
            'component', 'metric', 'paused',
        )
        widgets = {
            'component': StaticSelect(),
            'metric': StaticSelect(),
        }
