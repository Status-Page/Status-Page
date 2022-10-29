from statuspage.views import generic
from utilities.utils import shallow_compare_dict
from . import filtersets, forms, tables
from .models import *


class ObjectChangeListView(generic.ObjectListView):
    queryset = ObjectChange.objects.all()
    filterset = filtersets.ObjectChangeFilterSet
    filterset_form = forms.ObjectChangeFilterForm
    table = tables.ObjectChangeTable
    template_name = 'extras/objectchange_list.html'
    actions = ('export',)


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
