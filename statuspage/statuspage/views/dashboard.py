from django.db.models import Q
from django.shortcuts import redirect, render
from django.utils import timezone

from incidents.choices import IncidentStatusChoices
from incidents.models import Incident
from maintenances.choices import MaintenanceStatusChoices
from maintenances.models import Maintenance
from statuspage.views import BaseView


__all__ = (
    'DashboardHomeView',
)


class DashboardHomeView(BaseView):
    template_name = 'dashboard/home.html'

    def get(self, request):
        if not request.user.is_authenticated:
            return redirect("login")

        open_incidents = Incident.objects.filter(
            ~Q(status=IncidentStatusChoices.RESOLVED)
        )
        open_maintenances = Maintenance.objects.filter(
            ~Q(status=MaintenanceStatusChoices.COMPLETED)
        )
        upcoming_maintenances = Maintenance.objects.filter(
            ~Q(status=MaintenanceStatusChoices.COMPLETED),
            scheduled_at__gte=timezone.now(),
        )

        return render(request, self.template_name, {
            'open_incidents': len(open_incidents),
            'open_maintenances': len(open_maintenances),
            'upcoming_maintenances': len(upcoming_maintenances),
        })
