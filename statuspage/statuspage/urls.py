from django.conf import settings
from django.views.static import serve

from extras.plugins.urls import plugin_patterns, plugin_api_patterns, plugin_admin_patterns
from .admin import admin_site
from django.urls import path, include, re_path
from statuspage.views import HomeView, DashboardHomeView, SubscriberVerifyView, SubscriberManageView, \
    SubscriberUnsubscribeView, SubscriberSubscribeView, SubscriberRequestManagementKeyView
from users.views import LoginView, LogoutView
from statuspage.api.views import APIRootView
from drf_yasg import openapi
from drf_yasg.views import get_schema_view

openapi_info = openapi.Info(
    title="Status-Page API",
    default_version='v1',
    description="API to access Status-Page",
    terms_of_service="https://github.com/status-page/status-page",
    license=openapi.License(name="Apache 2.0 License"),
)

schema_view = get_schema_view(
    openapi_info,
    validators=['flex', 'ssv'],
    public=True,
    permission_classes=()
)

_patterns = [
    # Base Views
    path('', HomeView.as_view(), name='home'),

    path('subscribers/subscribe', SubscriberSubscribeView.as_view(), name='subscriber_subscribe'),
    path('subscribers/reqeust-management-key', SubscriberRequestManagementKeyView.as_view(), name='subscriber_management_key'),
    path('subscribers/<str:management_key>/verify', SubscriberVerifyView.as_view(), name='subscriber_verify'),
    path('subscribers/<str:management_key>/manage', SubscriberManageView.as_view(), name='subscriber_manage'),
    path('subscribers/<str:management_key>/unsubscribe', SubscriberUnsubscribeView.as_view(), name='subscriber_unsubscribe'),

    path('dashboard/', DashboardHomeView.as_view(), name='dashboard'),
    path('dashboard/login/', LoginView.as_view(), name='login'),
    path('dashboard/logout/', LogoutView.as_view(), name='logout'),

    # Apps
    path('dashboard/components/', include('components.urls')),
    path('dashboard/extras/', include('extras.urls')),
    path('dashboard/incidents/', include('incidents.urls')),
    path('dashboard/maintenances/', include('maintenances.urls')),
    path('dashboard/metrics/', include('metrics.urls')),
    path('dashboard/subscribers/', include('subscribers.urls')),
    path('dashboard/user/', include('users.urls')),

    # API
    path('api/', APIRootView.as_view(), name='api-root'),
    path('api/components/', include('components.api.urls')),
    path('api/extras/', include('extras.api.urls')),
    path('api/incidents/', include('incidents.api.urls')),
    path('api/maintenances/', include('maintenances.api.urls')),
    path('api/metrics/', include('metrics.api.urls')),
    path('api/subscribers/', include('subscribers.api.urls')),
    path('api/users/', include('users.api.urls')),
    path('api/docs/', schema_view.with_ui('swagger', cache_timeout=86400), name='api_docs'),
    path('api/redoc/', schema_view.with_ui('redoc', cache_timeout=86400), name='api_redocs'),
    re_path(r'^api/swagger(?P<format>.json|.yaml)$', schema_view.without_ui(cache_timeout=86400),
            name='schema_swagger'),

    path('media/<path:path>', serve, {'document_root': settings.MEDIA_ROOT}),

    # Plugins
    path('plugins/', include((plugin_patterns, 'plugins'))),
    path('api/plugins/', include((plugin_api_patterns, 'plugins-api'))),

    # Admin
    path('admin/background-tasks/', include('django_rq.urls')),
    path('admin/plugins/', include(plugin_admin_patterns)),
    path('admin/', admin_site.urls),

    path('__reload__/', include('django_browser_reload.urls')),
]

# Prepend BASE_PATH
urlpatterns = [
    path('{}'.format(settings.BASE_PATH), include(_patterns))
]
