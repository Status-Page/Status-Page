import logging

from django.contrib import messages
from django.core.exceptions import FieldDoesNotExist, ValidationError
from django.db import transaction
from django.db.models import ManyToManyField, ManyToManyRel, ProtectedError
from django.forms import ModelMultipleChoiceField, MultipleHiddenInput
from django.shortcuts import render, redirect
from django.utils.safestring import mark_safe

from utilities.error_handlers import handle_protectederror
from utilities.exceptions import PermissionsViolation, AbortRequest
from utilities.forms import restrict_form_fields, ConfirmationForm
from utilities.htmx import is_htmx
from utilities.permissions import get_permission_for_model
from utilities.views import GetReturnURLMixin
from .base import BaseMultiObjectView
from .mixins import ActionsMixin, TableMixin

__all__ = (
    'ObjectListView',
    'BulkEditView',
    'BulkDeleteView',
)


class ObjectListView(BaseMultiObjectView, ActionsMixin, TableMixin):
    """
    Display multiple objects, all the same type, as a table.
    Attributes:
        filterset: A django-filter FilterSet that is applied to the queryset
        filterset_form: The form class used to render filter options
        actions: Supported actions for the model. When adding custom actions, bulk action names must
            be prefixed with `bulk_`. Default actions: add, import, export, bulk_edit, bulk_delete
        action_perms: A dictionary mapping supported actions to a set of permissions required for each
    """
    template_name = 'generic/object_list.html'
    filterset = None
    filterset_form = None

    def get_required_permission(self):
        return get_permission_for_model(self.queryset.model, 'view')

    def get(self, request):
        """
        GET request handler.
        Args:
            request: The current request
        """
        model = self.queryset.model

        if self.filterset:
            self.queryset = self.filterset(request.GET, self.queryset).qs

        # Determine the available actions
        actions = self.get_permitted_actions(request.user)
        has_bulk_actions = any([a.startswith('bulk_') for a in actions])

        # Render the objects table
        table = self.get_table(self.queryset, request, has_bulk_actions)

        if is_htmx(request):
            return render(request, 'htmx/table.html', {
                'table': table,
            })

        context = {
            'model': model,
            'table': table,
            'actions': actions,
            'filter_form': self.filterset_form(request.GET, label_suffix='') if self.filterset_form else None,
            **self.get_extra_context(request),
        }

        return render(request, self.template_name, context)


class BulkEditView(GetReturnURLMixin, BaseMultiObjectView):
    """
    Edit objects in bulk.
    Attributes:
        filterset: FilterSet to apply when deleting by QuerySet
        form: The form class used to edit objects in bulk
    """
    template_name = 'generic/bulk_edit.html'
    filterset = None
    form = None

    def get_required_permission(self):
        return get_permission_for_model(self.queryset.model, 'change')

    def _update_objects(self, form, request):
        custom_fields = getattr(form, 'custom_fields', [])
        standard_fields = [
            field for field in form.fields if field not in list(custom_fields) + ['pk']
        ]
        nullified_fields = request.POST.getlist('_nullify')
        updated_objects = []

        for obj in self.queryset.filter(pk__in=form.cleaned_data['pk']):

            # Take a snapshot of change-logged models
            if hasattr(obj, 'snapshot'):
                obj.snapshot()

            # Update standard fields. If a field is listed in _nullify, delete its value.
            for name in standard_fields:

                try:
                    model_field = self.queryset.model._meta.get_field(name)
                except FieldDoesNotExist:
                    # This form field is used to modify a field rather than set its value directly
                    model_field = None

                # Handle nullification
                if name in form.nullable_fields and name in nullified_fields:
                    if isinstance(model_field, ManyToManyField):
                        getattr(obj, name).set([])
                    else:
                        setattr(obj, name, None if model_field.null else '')

                # ManyToManyFields
                elif isinstance(model_field, (ManyToManyField, ManyToManyRel)):
                    if form.cleaned_data[name]:
                        getattr(obj, name).set(form.cleaned_data[name])
                # Normal fields
                elif name in form.changed_data:
                    setattr(obj, name, form.cleaned_data[name])

            obj.full_clean()
            obj.save()
            updated_objects.append(obj)

        return updated_objects

    #
    # Request handlers
    #

    def get(self, request):
        return redirect(self.get_return_url(request))

    def post(self, request, **kwargs):
        logger = logging.getLogger('statuspage.views.BulkEditView')
        model = self.queryset.model

        # If we are editing *all* objects in the queryset, replace the PK list with all matched objects.
        if request.POST.get('_all') and self.filterset is not None:
            pk_list = self.filterset(request.GET, self.queryset.values_list('pk', flat=True)).qs
        else:
            pk_list = request.POST.getlist('pk')

        # Include the PK list as initial data for the form
        initial_data = {'pk': pk_list}

        # Check for other contextual data needed for the form. We avoid passing all of request.GET because the
        # filter values will conflict with the bulk edit form fields.
        # TODO: Find a better way to accomplish this
        if 'device' in request.GET:
            initial_data['device'] = request.GET.get('device')
        elif 'device_type' in request.GET:
            initial_data['device_type'] = request.GET.get('device_type')
        elif 'virtual_machine' in request.GET:
            initial_data['virtual_machine'] = request.GET.get('virtual_machine')

        if '_apply' in request.POST:
            form = self.form(request.POST, initial=initial_data)
            restrict_form_fields(form, request.user)

            if form.is_valid():
                logger.debug("Form validation was successful")

                try:

                    with transaction.atomic():
                        updated_objects = self._update_objects(form, request)

                        # Enforce object-level permissions
                        object_count = self.queryset.filter(pk__in=[obj.pk for obj in updated_objects]).count()
                        if object_count != len(updated_objects):
                            raise PermissionsViolation

                    if updated_objects:
                        msg = f'Updated {len(updated_objects)} {model._meta.verbose_name_plural}'
                        logger.info(msg)
                        messages.success(self.request, msg)

                    return redirect(self.get_return_url(request))

                except ValidationError as e:
                    messages.error(self.request, ", ".join(e.messages))

                except (AbortRequest, PermissionsViolation) as e:
                    logger.debug(e.message)
                    form.add_error(None, e.message)

            else:
                logger.debug("Form validation failed")

        else:
            form = self.form(initial=initial_data)
            restrict_form_fields(form, request.user)

        # Retrieve objects being edited
        table = self.table(self.queryset.filter(pk__in=pk_list), orderable=False)
        if not table.rows:
            messages.warning(request, "No {} were selected.".format(model._meta.verbose_name_plural))
            return redirect(self.get_return_url(request))

        return render(request, self.template_name, {
            'model': model,
            'form': form,
            'table': table,
            'return_url': self.get_return_url(request),
            **self.get_extra_context(request),
        })


class BulkDeleteView(GetReturnURLMixin, BaseMultiObjectView):
    """
    Delete objects in bulk.
    Attributes:
        filterset: FilterSet to apply when deleting by QuerySet
        table: The table used to display devices being deleted
    """
    template_name = 'generic/bulk_delete.html'
    filterset = None
    table = None

    def get_required_permission(self):
        return get_permission_for_model(self.queryset.model, 'delete')

    def get_form(self):
        """
        Provide a standard bulk delete form if none has been specified for the view
        """
        class BulkDeleteForm(ConfirmationForm):
            pk = ModelMultipleChoiceField(queryset=self.queryset, widget=MultipleHiddenInput)

        return BulkDeleteForm

    #
    # Request handlers
    #

    def get(self, request):
        return redirect(self.get_return_url(request))

    def post(self, request, **kwargs):
        logger = logging.getLogger('statuspage.views.BulkDeleteView')
        model = self.queryset.model

        # Are we deleting *all* objects in the queryset or just a selected subset?
        if request.POST.get('_all'):
            qs = model.objects.all()
            if self.filterset is not None:
                qs = self.filterset(request.GET, qs).qs
            pk_list = qs.only('pk').values_list('pk', flat=True)
        else:
            pk_list = [int(pk) for pk in request.POST.getlist('pk')]

        form_cls = self.get_form()

        if '_confirm' in request.POST:
            form = form_cls(request.POST)
            if form.is_valid():
                logger.debug("Form validation was successful")

                # Delete objects
                queryset = self.queryset.filter(pk__in=pk_list)
                deleted_count = queryset.count()
                try:
                    for obj in queryset:
                        # Take a snapshot of change-logged models
                        if hasattr(obj, 'snapshot'):
                            obj.snapshot()
                        obj.delete()

                except ProtectedError as e:
                    logger.info("Caught ProtectedError while attempting to delete objects")
                    handle_protectederror(queryset, request, e)
                    return redirect(self.get_return_url(request))

                except AbortRequest as e:
                    logger.debug(e.message)
                    messages.error(request, mark_safe(e.message))
                    return redirect(self.get_return_url(request))

                msg = f"Deleted {deleted_count} {model._meta.verbose_name_plural}"
                logger.info(msg)
                messages.success(request, msg)
                return redirect(self.get_return_url(request))

            else:
                logger.debug("Form validation failed")

        else:
            form = form_cls(initial={
                'pk': pk_list,
                'return_url': self.get_return_url(request),
            })

        # Retrieve objects being deleted
        table = self.table(self.queryset.filter(pk__in=pk_list), orderable=False)
        if not table.rows:
            messages.warning(request, "No {} were selected for deletion.".format(model._meta.verbose_name_plural))
            return redirect(self.get_return_url(request))

        return render(request, self.template_name, {
            'model': model,
            'form': form,
            'table': table,
            'return_url': self.get_return_url(request),
            **self.get_extra_context(request),
        })
