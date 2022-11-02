import datetime

from metrics.models import MetricPoint
from sp_uptimerobot.models import UptimeRobotMonitor
from sp_uptimerobot.uptimerobot import UptimeRobot


def sync_uptimerobot_data():
    ur = UptimeRobot()

    data = ur.getMonitors()
    monitors = data['monitors']

    monitors_to_delete = list(UptimeRobotMonitor.objects.all())

    for monitor in monitors:
        def has_maintenance_window():
            has_active = False
            for mwindow in monitor['mwindows']:
                start_time = datetime.datetime.fromtimestamp(mwindow['start_time'])
                duration = mwindow['duration']
                end_time = start_time + datetime.timedelta(minutes=int(duration))
                if start_time < datetime.datetime.now() < end_time:
                    has_active = True
            return has_active

        m = UptimeRobotMonitor.by_monitor_id(monitor['id'])
        if m:
            monitors_to_delete.remove(m)
        if not m:
            m = UptimeRobotMonitor()
            m.monitor_id = monitor['id']
        m.friendly_name = monitor['friendly_name']
        m.status_id = 0 if has_maintenance_window() else monitor['status']
        m.save()

        if not m.paused and m.component:
            m.component.status = m.status
            m.component.save()

        if not m.paused and m.metric and not has_maintenance_window() and len(monitor['response_times']) > 0:
            mp = MetricPoint()
            mp.metric = m.metric
            mp.value = monitor['response_times'][0]['value']
            mp.save()

    for m in monitors_to_delete:
        m.delete()


schedules = [(sync_uptimerobot_data, '* * * * *')]
