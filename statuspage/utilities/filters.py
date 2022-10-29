import django_filters
from django import forms
from django_filters.constants import EMPTY_VALUES


def multivalue_field_factory(field_class):
    """
    Given a form field class, return a subclass capable of accepting multiple values. This allows us to OR on multiple
    filter values while maintaining the field's built-in validation. Example: GET /api/dcim/devices/?name=foo&name=bar
    """
    class NewField(field_class):
        widget = forms.SelectMultiple

        def to_python(self, value):
            if not value:
                return []
            field = field_class()
            return [
                # Only append non-empty values (this avoids e.g. trying to cast '' as an integer)
                field.to_python(v) for v in value if v
            ]

    return type('MultiValue{}'.format(field_class.__name__), (NewField,), dict())


class MultiValueCharFilter(django_filters.MultipleChoiceFilter):
    field_class = multivalue_field_factory(forms.CharField)


class MultiValueDateFilter(django_filters.MultipleChoiceFilter):
    field_class = multivalue_field_factory(forms.DateField)


class MultiValueDateTimeFilter(django_filters.MultipleChoiceFilter):
    field_class = multivalue_field_factory(forms.DateTimeField)


class MultiValueNumberFilter(django_filters.MultipleChoiceFilter):
    field_class = multivalue_field_factory(forms.IntegerField)


class MultiValueTimeFilter(django_filters.MultipleChoiceFilter):
    field_class = multivalue_field_factory(forms.TimeField)


class ContentTypeFilter(django_filters.CharFilter):
    """
    Allow specifying a ContentType by <app_label>.<model> (e.g. "dcim.site").
    """
    def filter(self, qs, value):
        if value in EMPTY_VALUES:
            return qs

        try:
            app_label, model = value.lower().split('.')
        except ValueError:
            return qs.none()
        return qs.filter(
            **{
                f'{self.field_name}__app_label': app_label,
                f'{self.field_name}__model': model
            }
        )


class TreeNodeMultipleChoiceFilter(django_filters.ModelMultipleChoiceFilter):
    """
    Filters for a set of Models, including all descendant models within a Tree.  Example: [<Region: R1>,<Region: R2>]
    """
    def get_filter_predicate(self, v):
        # Null value filtering
        if v is None:
            return {f"{self.field_name}__isnull": True}
        return super().get_filter_predicate(v)

    def filter(self, qs, value):
        value = [node.get_descendants(include_self=True) if not isinstance(node, str) else node for node in value]
        return super().filter(qs, value)
