from django.conf import settings as django_settings

from extras.registry import registry
from statuspage.config import get_config


def settings_and_registry(request):
    """
    Expose Django settings and Status-Page registry stores in the template context. Example: {{ settings.DEBUG }}
    """
    return {
        'settings': django_settings,
        'config': get_config(),
        'registry': registry,
        'preferences': request.user.config if request.user.is_authenticated else {},
    }
