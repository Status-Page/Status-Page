from django.conf import settings
from django.contrib.admin import site as admin_site
from django_otp.admin import OTPAdminAuthenticationForm

# Override default AdminSite attributes, so we can avoid creating and
# registering our own class
admin_site.site_header = 'Status-Page Administration'
admin_site.site_title = 'Status-Page'
admin_site.site_url = '/{}'.format(settings.BASE_PATH)
admin_site.index_template = 'admin/index.html'
admin_site.login_form = OTPAdminAuthenticationForm
admin_site.login_template = 'otp/admin111/login.html'
