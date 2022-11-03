from extras.plugins import PluginConfig


class StatusPageExternalStatusProvidersConfig(PluginConfig):
    name = 'sp_external_status_providers'
    verbose_name = '[SP] External Status Providers'
    description = 'Sync components and incidents from other Status Pages'
    version = '1.0'
    author = 'HerrTxbias'
    author_email = 'admin@herrtxbias.net'
    base_url = 'external-status-providers'
    required_settings = []
    default_settings = {}


config = StatusPageExternalStatusProvidersConfig
