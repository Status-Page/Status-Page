from collections import defaultdict

from django.contrib.auth.backends import ModelBackend
from django.db.models import Q

from users.constants import CONSTRAINT_TOKEN_USER
from users.models import ObjectPermission
from utilities.permissions import resolve_permission, permission_is_exempt, qs_filter_from_constraints


class ObjectPermissionMixin:

    def get_all_permissions(self, user_obj, obj=None):
        if not user_obj.is_active or user_obj.is_anonymous:
            return dict()
        if not hasattr(user_obj, '_object_perm_cache'):
            user_obj._object_perm_cache = self.get_object_permissions(user_obj)
        return user_obj._object_perm_cache

    def get_permission_filter(self, user_obj):
        return Q(users=user_obj) | Q(groups__user=user_obj)

    def get_object_permissions(self, user_obj):
        """
        Return all permissions granted to the user by an ObjectPermission.
        """
        # Retrieve all assigned and enabled ObjectPermissions
        object_permissions = ObjectPermission.objects.filter(
            self.get_permission_filter(user_obj),
            enabled=True
        ).order_by('id').distinct('id').prefetch_related('object_types')

        # Create a dictionary mapping permissions to their constraints
        perms = defaultdict(list)
        for obj_perm in object_permissions:
            for object_type in obj_perm.object_types.all():
                for action in obj_perm.actions:
                    perm_name = f"{object_type.app_label}.{action}_{object_type.model}"
                    perms[perm_name].extend(obj_perm.list_constraints())

        return perms

    def has_perm(self, user_obj, perm, obj=None):
        app_label, action, model_name = resolve_permission(perm)

        # Superusers implicitly have all permissions
        if user_obj.is_active and user_obj.is_superuser:
            return True

        # Permission is exempt from enforcement (i.e. listed in EXEMPT_VIEW_PERMISSIONS)
        if permission_is_exempt(perm):
            return True

        # Handle inactive/anonymous users
        if not user_obj.is_active or user_obj.is_anonymous:
            return False

        object_permissions = self.get_all_permissions(user_obj)

        # If no applicable ObjectPermissions have been created for this user/permission, deny permission
        if perm not in object_permissions:
            return False

        # If no object has been specified, grant permission. (The presence of a permission in this set tells
        # us that the user has permission for *some* objects, but not necessarily a specific object.)
        if obj is None:
            return True

        # Sanity check: Ensure that the requested permission applies to the specified object
        model = obj._meta.model
        if model._meta.label_lower != '.'.join((app_label, model_name)):
            raise ValueError(f"Invalid permission {perm} for model {model}")

        # Compile a QuerySet filter that matches all instances of the specified model
        tokens = {
            CONSTRAINT_TOKEN_USER: user_obj,
        }
        qs_filter = qs_filter_from_constraints(object_permissions[perm], tokens)

        # Permission to perform the requested action on the object depends on whether the specified object matches
        # the specified constraints. Note that this check is made against the *database* record representing the object,
        # not the instance itself.
        return model.objects.filter(qs_filter, pk=obj.pk).exists()


class ObjectPermissionBackend(ObjectPermissionMixin, ModelBackend):
    pass
