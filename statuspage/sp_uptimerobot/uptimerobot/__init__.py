from django.conf import settings
import requests


class UptimeRobot:
    def __init__(self, api_version='2'):
        self._api_key = settings.PLUGINS_CONFIG['sp_uptimerobot']['uptime_robot_api_key']
        self._api_url = f'https://api.uptimerobot.com/v{api_version}'

    def getMonitors(self):
        r = requests.post(
            url=f'{self._api_url}/getMonitors',
            data={
                'api_key': self._api_key,
                'format': 'json',
                'response_times': 1,
                'mwindows': 1,
                'timezone': 1,
                'response_times_limit': 5,
            },
            headers={
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
            })
        return r.json()
