import platform
import sys

from django.conf import settings
from django.views.decorators.csrf import requires_csrf_token
from django.views.defaults import ERROR_500_TEMPLATE_NAME
from django.template import loader
from django.template.exceptions import TemplateDoesNotExist
from django.http import HttpResponseServerError

from statuspage.views.generic import BaseView

from .dashboard import *
from .home import *
from .subscriber import *


@requires_csrf_token
def server_error(request, template_name=ERROR_500_TEMPLATE_NAME):
    """
    Custom 500 handler to provide additional context when rendering 500.html.
    """
    try:
        template = loader.get_template(template_name)
    except TemplateDoesNotExist:
        return HttpResponseServerError('<h1>Server Error (500)</h1>', content_type='text/html')
    type_, error, traceback = sys.exc_info()

    return HttpResponseServerError(template.render({
        'error': error,
        'exception': str(type_),
        'statuspage_version': settings.VERSION,
        'python_version': platform.python_version(),
    }))
