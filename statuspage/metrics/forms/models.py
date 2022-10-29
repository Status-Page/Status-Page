from statuspage.forms import StatusPageModelForm
from utilities.forms import StaticSelect
from ..models import Metric

__all__ = (
    'MetricForm',
)


class MetricForm(StatusPageModelForm):
    fieldsets = (
        ('Metric', (
            'title', 'suffix', 'visibility', 'order', 'expand'
        )),
    )

    class Meta:
        model = Metric
        fields = (
            'title', 'suffix', 'visibility', 'order', 'expand'
        )
        widgets = {
            'expand': StaticSelect(),
        }
