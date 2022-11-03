import requests

from sp_external_status_providers.providers import Provider


class AtlassianProvider(Provider):

    def __init__(self, page):
        self._page = page

    def get_components(self):
        r = requests.get(f'https://{self._page.domain}/api/v2/components.json')
        return r.json()['components']
