from django.db.models import Q
from django.utils.deconstruct import deconstructible

from extras.constants import EXTRAS_FEATURES
from statuspage.registry import registry


@deconstructible
class FeatureQuery:
    """
    Helper class that delays evaluation of the registry contents for the functionality store
    until it has been populated.
    """
    def __init__(self, feature):
        self.feature = feature

    def __call__(self):
        return self.get_query()

    def get_query(self):
        """
        Given an extras feature, return a Q object for content type lookup
        """
        query = Q()
        for app_label, models in registry['model_features'][self.feature].items():
            query |= Q(app_label=app_label, model__in=models)

        return query


def register_features(model, features):
    """
    Register model features in the application registry.
    """
    app_label, model_name = model._meta.label_lower.split('.')
    for feature in features:
        try:
            registry['model_features'][feature][app_label].add(model_name)
        except KeyError:
            raise KeyError(
                f"{feature} is not a valid model feature! Valid keys are: {registry['model_features'].keys()}"
            )
