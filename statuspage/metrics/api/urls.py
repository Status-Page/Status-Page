from statuspage.api.routers import StatusPageRouter
from . import views


router = StatusPageRouter()
router.APIRootView = views.MetricsRootView

router.register('metrics', views.MetricViewSet)
router.register('metric-points', views.MetricPointViewSet)

app_name = 'metrics-api'
urlpatterns = router.urls
