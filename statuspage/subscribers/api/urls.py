from statuspage.api.routers import StatusPageRouter
from . import views


router = StatusPageRouter()
router.APIRootView = views.SubscribersRootView

router.register('subscribers', views.SubscriberViewSet)

app_name = 'subscribers-api'
urlpatterns = router.urls
