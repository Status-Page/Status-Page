from django.contrib import admin

from .models import Maintenance, MaintenanceUpdate

admin.site.register(Maintenance)
admin.site.register(MaintenanceUpdate)
