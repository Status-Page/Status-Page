import os
import sys
import platform

# Build paths inside the project like this: BASE_DIR / 'subdir'.
# BASE_DIR = Path(__file__).resolve().parent.parent
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

BASE_PATH = ''

VERSION = '2.0.0-dev'

if sys.version_info < (3, 8):
    raise RuntimeError(
        f"Status-Page requires Python 3.8 or later. (Currently installed: Python {platform.python_version()})"
    )

# Quick-start development settings - unsuitable for production
# See https://docs.djangoproject.com/en/4.1/howto/deployment/checklist/

# SECURITY WARNING: keep the secret key used in production secret!
SECRET_KEY = 'django-insecure-*)!94*l12=&x-mei(zckk8g3sbh19cao)g+d(@hfmt@t1$vggy'

# SECURITY WARNING: don't run with debug turned on in production!
DEBUG = True

ALLOWED_HOSTS = [
    'localhost',
    '192.168.178.47',
]

LOGIN_URL = f'/{BASE_PATH}dashboard/login/'
LOGIN_REDIRECT_URL = f'/{BASE_PATH}dashboard/'

# Application definition

INSTALLED_APPS = [
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
    'rest_framework',
    'tailwind',
    'django_browser_reload',
    'django_tables2',
    'components',
    'extras',
    'incidents',
    'maintenances',
    'users',
    'utilities',
    'django_rq',
    'drf_yasg',
    'queuing',
    'django_otp',
    'django_otp.plugins.otp_static',
    'django_otp.plugins.otp_totp',
    'otp_yubikey',
]

MIDDLEWARE = [
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django_otp.middleware.OTPMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
    'django_browser_reload.middleware.BrowserReloadMiddleware',
    'statuspage.middleware.APIVersionMiddleware',
    'statuspage.middleware.ObjectChangeMiddleware',
]

ROOT_URLCONF = 'statuspage.urls'

TEMPLATES_DIR = f'{BASE_DIR}/templates'
TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [TEMPLATES_DIR],
        'APP_DIRS': True,
        'OPTIONS': {
            'builtins': [
                'utilities.templatetags.builtins.filters',
                'utilities.templatetags.builtins.tags',
            ],
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',
                'statuspage.context_processors.settings_and_registry',
            ],
        },
    },
]

WSGI_APPLICATION = 'statuspage.wsgi.application'


# Database
# https://docs.djangoproject.com/en/4.1/ref/settings/#databases

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.postgresql',
        'NAME': 'statuspage',
        'HOST': 'localhost',
        'PORT': '5432',
    }
}

RQ_QUEUES = {
    'default': {
        'HOST': 'localhost',
        'PORT': 6379,
        'DB': 0,
        'PASSWORD': 'yQxF_Es*7faQ3uTkRRUiQgqbuW9r6GoEJvL7bRkg_K8FW.oPp@93sFjWDAJ!c4AH',
    },
}

# Password validation
# https://docs.djangoproject.com/en/4.1/ref/settings/#auth-password-validators

AUTH_PASSWORD_VALIDATORS = [
    {
        'NAME': 'django.contrib.auth.password_validation.UserAttributeSimilarityValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.MinimumLengthValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.CommonPasswordValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.NumericPasswordValidator',
    },
]


# Internationalization
# https://docs.djangoproject.com/en/4.1/topics/i18n/

LANGUAGE_CODE = 'de-de'

TIME_ZONE = 'Europe/Berlin'

USE_I18N = True

USE_TZ = True


# Static files (CSS, JavaScript, Images)
# https://docs.djangoproject.com/en/4.1/howto/static-files/

STATIC_ROOT = BASE_DIR + '/static'
STATIC_URL = f'/{BASE_PATH}static/'
STATICFILES_DIRS = (
    os.path.join(BASE_DIR, 'project-static', 'dist'),
    os.path.join(BASE_DIR, 'project-static', 'img'),
    # ('docs', os.path.join(BASE_DIR, 'project-static', 'docs')),  # Prefix with /docs
)

# Default primary key field type
# https://docs.djangoproject.com/en/4.1/ref/settings/#default-auto-field

DEFAULT_AUTO_FIELD = 'django.db.models.BigAutoField'

REST_FRAMEWORK_VERSION = '.'.join(VERSION.split('-')[0].split('.')[:2])  # Use major.minor as API version
REST_FRAMEWORK = {
    'ALLOWED_VERSIONS': [REST_FRAMEWORK_VERSION],
    'COERCE_DECIMAL_TO_STRING': False,
    'DEFAULT_AUTHENTICATION_CLASSES': (
        'rest_framework.authentication.SessionAuthentication',
        'statuspage.api.authentication.TokenAuthentication',
    ),
    'DEFAULT_FILTER_BACKENDS': (
        'django_filters.rest_framework.DjangoFilterBackend',
        'rest_framework.filters.OrderingFilter',
    ),
    'DEFAULT_METADATA_CLASS': 'statuspage.api.metadata.BulkOperationMetadata',
    'DEFAULT_PAGINATION_CLASS': 'statuspage.api.pagination.OptionalLimitOffsetPagination',
    'DEFAULT_PARSER_CLASSES': (
        'rest_framework.parsers.JSONParser',
        'rest_framework.parsers.MultiPartParser',
    ),
    'DEFAULT_PERMISSION_CLASSES': (
        'statuspage.api.authentication.TokenPermissions',
    ),
    'DEFAULT_RENDERER_CLASSES': (
        'rest_framework.renderers.JSONRenderer',
        'statuspage.api.renderers.FormlessBrowsableAPIRenderer',
    ),
    'DEFAULT_VERSION': REST_FRAMEWORK_VERSION,
    'DEFAULT_VERSIONING_CLASS': 'rest_framework.versioning.AcceptHeaderVersioning',
    'SCHEMA_COERCE_METHOD_NAMES': {
        # Default mappings
        'retrieve': 'read',
        'destroy': 'delete',
        # Custom operations
        'bulk_destroy': 'bulk_delete',
    },
    'VIEW_NAME_FUNCTION': 'utilities.api.get_view_name',
}

SWAGGER_SETTINGS = {
    'DEFAULT_AUTO_SCHEMA_CLASS': 'utilities.custom_inspectors.StatusPageSwaggerAutoSchema',
    'DEFAULT_FIELD_INSPECTORS': [
        'utilities.custom_inspectors.NullableBooleanFieldInspector',
        'utilities.custom_inspectors.ChoiceFieldInspector',
        'utilities.custom_inspectors.SerializedPKRelatedFieldInspector',
        'drf_yasg.inspectors.CamelCaseJSONFilter',
        'drf_yasg.inspectors.ReferencingSerializerInspector',
        'drf_yasg.inspectors.RelatedFieldInspector',
        'drf_yasg.inspectors.ChoiceFieldInspector',
        'drf_yasg.inspectors.FileFieldInspector',
        'drf_yasg.inspectors.DictFieldInspector',
        'drf_yasg.inspectors.JSONFieldInspector',
        'drf_yasg.inspectors.SerializerMethodFieldInspector',
        'drf_yasg.inspectors.SimpleFieldInspector',
        'drf_yasg.inspectors.StringDefaultFieldInspector',
    ],
    'DEFAULT_FILTER_INSPECTORS': [
        'drf_yasg.inspectors.CoreAPICompatInspector',
    ],
    'DEFAULT_INFO': 'statuspage.urls.openapi_info',
    'DEFAULT_MODEL_DEPTH': 1,
    'DEFAULT_PAGINATOR_INSPECTORS': [
        'utilities.custom_inspectors.NullablePaginatorInspector',
        'drf_yasg.inspectors.DjangoRestResponsePagination',
        'drf_yasg.inspectors.CoreAPICompatInspector',
    ],
    'SECURITY_DEFINITIONS': {
        'Token': {
            'type': 'apiKey',
            'name': 'Authorization',
            'in': 'header',
        }
    },
    'VALIDATOR_URL': None,
}

FIELD_CHOICES = {}

EXEMPT_VIEW_PERMISSIONS = {}

AUTHENTICATION_BACKENDS = [
    'statuspage.authentication.ObjectPermissionBackend',
]

OTP_ADMIN_HIDE_SENSITIVE_DATA = True
