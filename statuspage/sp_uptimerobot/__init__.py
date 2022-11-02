from extras.plugins import PluginConfig


class StatusPageUptimeRobotConfig(PluginConfig):
    name = 'sp_uptimerobot'
    verbose_name = '[SP] Uptime Robot'
    description = 'Uptime Robot Monitor Sync'
    version = '1.0'
    author = 'HerrTxbias'
    author_email = 'admin@herrtxbias.net'
    base_url = 'uptime-robot'
    required_settings = [
        'uptime_robot_api_key',
    ]
    default_settings = {}


config = StatusPageUptimeRobotConfig
