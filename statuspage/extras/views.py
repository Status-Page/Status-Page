from statuspage.views import generic
from utilities.utils import shallow_compare_dict
from utilities.views import register_model_view
from . import filtersets, forms, tables
from .models import *


#
# Webhooks
#

@register_model_view(Webhook, 'list')
class WebhookListView(generic.ObjectListView):
    queryset = Webhook.objects.all()
    filterset = filtersets.WebhookFilterSet
    filterset_form = forms.WebhookFilterForm
    table = tables.WebhookTable


@register_model_view(Webhook)
class WebhookView(generic.ObjectView):
    queryset = Webhook.objects.all()


@register_model_view(Webhook, 'edit')
@register_model_view(Webhook, 'add')
class WebhookEditView(generic.ObjectEditView):
    queryset = Webhook.objects.all()
    form = forms.WebhookForm


@register_model_view(Webhook, 'delete')
class WebhookDeleteView(generic.ObjectDeleteView):
    queryset = Webhook.objects.all()


# class WebhookBulkImportView(generic.BulkImportView):
#    queryset = Webhook.objects.all()
#    model_form = forms.WebhookImportForm


@register_model_view(Webhook, 'bulk_edit')
class WebhookBulkEditView(generic.BulkEditView):
    queryset = Webhook.objects.all()
    filterset = filtersets.WebhookFilterSet
    table = tables.WebhookTable
    form = forms.WebhookBulkEditForm


@register_model_view(Webhook, 'bulk_delete')
class WebhookBulkDeleteView(generic.BulkDeleteView):
    queryset = Webhook.objects.all()
    filterset = filtersets.WebhookFilterSet
    table = tables.WebhookTable


@register_model_view(ObjectChange, 'list')
class ObjectChangeListView(generic.ObjectListView):
    queryset = ObjectChange.objects.all()
    filterset = filtersets.ObjectChangeFilterSet
    filterset_form = forms.ObjectChangeFilterForm
    table = tables.ObjectChangeTable
    template_name = 'extras/objectchange_list.html'
    actions = ('export',)


@register_model_view(ObjectChange)
class ObjectChangeView(generic.ObjectView):
    queryset = ObjectChange.objects.all()

    def get_extra_context(self, request, instance):
        related_changes = ObjectChange.objects.restrict(request.user, 'view').filter(
            request_id=instance.request_id
        ).exclude(
            pk=instance.pk
        )
        related_changes_table = tables.ObjectChangeTable(
            data=related_changes[:50],
            orderable=False
        )

        objectchanges = ObjectChange.objects.restrict(request.user, 'view').filter(
            changed_object_type=instance.changed_object_type,
            changed_object_id=instance.changed_object_id,
        )

        next_change = objectchanges.filter(time__gt=instance.time).order_by('time').first()
        prev_change = objectchanges.filter(time__lt=instance.time).order_by('-time').first()

        if not instance.prechange_data and instance.action in ['update', 'delete'] and prev_change:
            non_atomic_change = True
            prechange_data = prev_change.postchange_data
        else:
            non_atomic_change = False
            prechange_data = instance.prechange_data

        if prechange_data and instance.postchange_data:
            diff_added = shallow_compare_dict(
                prechange_data or dict(),
                instance.postchange_data or dict(),
                exclude=['last_updated'],
            )
            diff_removed = {
                x: prechange_data.get(x) for x in diff_added
            } if prechange_data else {}
        else:
            diff_added = None
            diff_removed = None

        return {
            'diff_added': diff_added,
            'diff_removed': diff_removed,
            'next_change': next_change,
            'prev_change': prev_change,
            'related_changes_table': related_changes_table,
            'related_changes_count': related_changes.count(),
            'non_atomic_change': non_atomic_change
        }
