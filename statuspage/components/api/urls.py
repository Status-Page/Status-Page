from statuspage.api.routers import StatusPageRouter
from . import views


router = StatusPageRouter()
router.APIRootView = views.ComponentsRootView

router.register('components', views.ComponentViewSet)
router.register('component-groups', views.ComponentGroupViewSet)

app_name = 'components-api'
urlpatterns = router.urls
