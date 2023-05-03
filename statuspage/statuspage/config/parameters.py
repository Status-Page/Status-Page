from django import forms
from django.contrib.postgres.forms import SimpleArrayField


class ConfigParam:

    def __init__(self, name, label, default, description='', field=None, field_kwargs=None):
        self.name = name
        self.label = label
        self.default = default
        self.field = field or forms.CharField
        self.description = description
        self.field_kwargs = field_kwargs or {}


PARAMS = (
    # General
    ConfigParam(
        name='SITE_TITLE',
        label='Site Title',
        default='Status-Page',
        description='The Title of the Page',
    ),
    ConfigParam(
        name='SITE_SUBSCRIBERS',
        label='Subscriptions',
        description='Enable Notification Subscriptions (Requires correct E-Mail server setup)',
        default=False,
        field=forms.BooleanField,
    ),

    # Custom Styling
    ConfigParam(
        name='HIDE_HISTORY_WHEN_EMPTY',
        label='Hide Incident / Maintenance history when empty',
        default=False,
        field=forms.BooleanField,
    ),

    ConfigParam(
        name='CUSTOM_STYLE_HEADER',
        label='Header HTML',
        default='',
        field_kwargs={
            'widget': forms.Textarea(
                attrs={'class': 'vLargeTextField'}
            ),
        },
    ),
    ConfigParam(
        name='CUSTOM_STYLE_HEADER_DISABLE_CORE',
        label='Disable Header from Status-Page',
        default=False,
        field=forms.BooleanField,
    ),

    ConfigParam(
        name='CUSTOM_STYLE_FOOTER',
        label='Footer HTML',
        default='',
        field_kwargs={
            'widget': forms.Textarea(
                attrs={'class': 'vLargeTextField'}
            ),
        },
    ),
    ConfigParam(
        name='CUSTOM_STYLE_FOOTER_DISABLE_CORE',
        label='Disable Footer from Status-Page',
        default=False,
        field=forms.BooleanField,
    ),

    ConfigParam(
        name='CUSTOM_STYLE_CSS',
        label='Custom CSS',
        default='',
        field_kwargs={
            'widget': forms.Textarea(
                attrs={'class': 'vLargeTextField'}
            ),
        },
    ),

    # Security
    ConfigParam(
        name='ALLOWED_URL_SCHEMES',
        label='Allowed URL schemes',
        default=(
            'file', 'ftp', 'ftps', 'http', 'https', 'irc', 'mailto', 'sftp', 'ssh', 'tel', 'telnet', 'tftp', 'vnc',
            'xmpp',
        ),
        description="Permitted schemes for URLs in user-provided content",
        field=SimpleArrayField,
        field_kwargs={'base_field': forms.CharField()}
    ),
    ConfigParam(
        name='CAPTCHA_PROVIDER',
        label='Captcha Provider',
        default=None,
        field=forms.ChoiceField,
        field_kwargs={
            'choices': [
                (None, '---------'),
                ('TURNSTILE', 'CloudFlare Turnstile'),
                ('RECAPTCHA_V2', 'Google reCAPTCHA v2'),
                ('HCAPTCHA', 'hCaptcha'),
            ],
        },
    ),
    ConfigParam(
        name='CAPTCHA_PUBLIC_KEY',
        label='Captcha Public Key',
        default='',
        field=forms.CharField,
    ),
    ConfigParam(
        name='CAPTCHA_PRIVATE_KEY',
        label='Captcha Private Key',
        default='',
        field=forms.CharField,
    ),

    # Banners
    ConfigParam(
        name='BANNER_LOGIN',
        label='Login banner',
        default='',
        description="Additional content to display on the login page",
        field_kwargs={
            'widget': forms.Textarea(
                attrs={'class': 'vLargeTextField'}
            ),
        },
    ),
    ConfigParam(
        name='BANNER_TOP',
        label='Top banner',
        default='',
        description="Additional content to display at the top of every page",
        field_kwargs={
            'widget': forms.Textarea(
                attrs={'class': 'vLargeTextField'}
            ),
        },
    ),
    ConfigParam(
        name='BANNER_BOTTOM',
        label='Bottom banner',
        default='',
        description="Additional content to display at the bottom of every page",
        field_kwargs={
            'widget': forms.Textarea(
                attrs={'class': 'vLargeTextField'}
            ),
        },
    ),

    # Pagination
    ConfigParam(
        name='PAGINATE_COUNT',
        label='Default page size',
        default=50,
        field=forms.IntegerField
    ),
    ConfigParam(
        name='MAX_PAGE_SIZE',
        label='Maximum page size',
        default=1000,
        field=forms.IntegerField
    ),

    # User preferences
    ConfigParam(
        name='DEFAULT_USER_PREFERENCES',
        label='Default preferences',
        default={},
        description="Default preferences for new users",
        field=forms.JSONField
    ),

    # Miscellaneous
    ConfigParam(
        name='MAINTENANCE_MODE',
        label='Maintenance mode',
        default=False,
        description="Enable maintenance mode",
        field=forms.BooleanField
    ),
    ConfigParam(
        name='CHANGELOG_RETENTION',
        label='Changelog retention',
        default=90,
        description="Days to retain changelog history (set to zero for unlimited)",
        field=forms.IntegerField
    ),

)
