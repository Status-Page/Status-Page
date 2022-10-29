from django.conf import settings
from .admin import admin_site
from django.urls import path, include, re_path
from statuspage.views import HomeView, DashboardHomeView
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
    path('dashboard/', DashboardHomeView.as_view(), name='dashboard'),
    path('dashboard/login/', LoginView.as_view(), name='login'),
    path('dashboard/logout/', LogoutView.as_view(), name='logout'),

    # Apps
    path('dashboard/components/', include('components.urls')),
    path('dashboard/incidents/', include('incidents.urls')),
    path('dashboard/maintenances/', include('maintenances.urls')),
    path('dashboard/metrics/', include('metrics.urls')),
    path('dashboard/extras/', include('extras.urls')),
    path('dashboard/user/', include('users.urls')),

    # API
    path('api/', APIRootView.as_view(), name='api-root'),
    path('api/users/', include('users.api.urls')),
    path('api/extras/', include('extras.api.urls')),
    path('api/docs/', schema_view.with_ui('swagger', cache_timeout=86400), name='api_docs'),
    path('api/redoc/', schema_view.with_ui('redoc', cache_timeout=86400), name='api_redocs'),
    re_path(r'^api/swagger(?P<format>.json|.yaml)$', schema_view.without_ui(cache_timeout=86400),
            name='schema_swagger'),

    # Admin
    path('admin/background-tasks/', include('django_rq.urls')),
    path('admin/', admin_site.urls),

    path('__reload__/', include('django_browser_reload.urls')),
]

# Prepend BASE_PATH
urlpatterns = [
    path('{}'.format(settings.BASE_PATH), include(_patterns))
]
