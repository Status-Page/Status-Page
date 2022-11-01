from statuspage.api.routers import StatusPageRouter
from . import views


router = StatusPageRouter()
router.APIRootView = views.IncidentsRootView

router.register('incidents', views.IncidentViewSet)
router.register('incident-updates', views.IncidentUpdateViewSet)

app_name = 'incidents-api'
urlpatterns = router.urls
