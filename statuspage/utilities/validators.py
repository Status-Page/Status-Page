import re

from django.core.validators import URLValidator
from django.utils.regex_helper import _lazy_re_compile

from statuspage.config import get_config


class EnhancedURLValidator(URLValidator):
    """
    Extends Django's built-in URLValidator to permit the use of hostnames with no domain extension and enforce allowed
    schemes specified in the configuration.
    """
    fqdn_re = URLValidator.hostname_re + URLValidator.domain_re + URLValidator.tld_re
    host_res = [URLValidator.ipv4_re, URLValidator.ipv6_re, fqdn_re, URLValidator.hostname_re]
    regex = _lazy_re_compile(
        r'^(?:[a-z0-9\.\-\+]*)://'          # Scheme (enforced separately)
        r'(?:\S+(?::\S*)?@)?'               # HTTP basic authentication
        r'(?:' + '|'.join(host_res) + ')'   # IPv4, IPv6, FQDN, or hostname
        r'(?::\d{2,5})?'                    # Port number
        r'(?:[/?#][^\s]*)?'                 # Path
        r'\Z', re.IGNORECASE)
    schemes = None

    def __call__(self, value):
        if self.schemes is None:
            # We can't load the allowed schemes until the configuration has been initialized
            self.schemes = get_config().ALLOWED_URL_SCHEMES
        return super().__call__(value)
