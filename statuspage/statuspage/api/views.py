from rest_framework.response import Response
from rest_framework.reverse import reverse
from rest_framework.views import APIView


class APIRootView(APIView):
    """
    This is the root of Status-Pages' REST API.
    API endpoints are arranged by app and model name: e.g. `/api/components/components/`.
    """
    _ignore_model_permissions = True
    exclude_from_schema = True
    swagger_schema = None

    def get_view_name(self):
        return "API Root"

    def get(self, request, format=None):

        return Response({
            'components': reverse('components-api:api-root', request=request, format=format),
            'extras': reverse('extras-api:api-root', request=request, format=format),
            'incidents': reverse('incidents-api:api-root', request=request, format=format),
            'maintenances': reverse('maintenances-api:api-root', request=request, format=format),
            'metrics': reverse('metrics-api:api-root', request=request, format=format),
            'subscribers': reverse('subscribers-api:api-root', request=request, format=format),
            'plugins': reverse('plugins-api:api-root', request=request, format=format),
            'users': reverse('users-api:api-root', request=request, format=format),
        })
