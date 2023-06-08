from django import forms
from django.contrib.contenttypes.models import ContentType
from django.db.models import Q

from utilities.utils import content_type_identifier

__all__ = (
    'CSVMultipleContentTypeField',
)


class CSVMultipleContentTypeField(forms.ModelMultipleChoiceField):
    """
    CSV field for referencing one or more content types, in the form `<app>.<model>`.
    """
    STATIC_CHOICES = True

    # TODO: Improve validation of selected ContentTypes
    def prepare_value(self, value):
        if type(value) is str:
            ct_filter = Q()
            for name in value.split(','):
                app_label, model = name.split('.')
                ct_filter |= Q(app_label=app_label, model=model)
            return list(ContentType.objects.filter(ct_filter).values_list('pk', flat=True))
        return content_type_identifier(value)
