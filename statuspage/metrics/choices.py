from utilities.choices import ChoiceSet


class MetricExpandChoices(ChoiceSet):
    key = 'Metric.expand'

    ALWAYS = 'always'
    ON_CLICK = 'on_click'

    CHOICES = [
        (ALWAYS, 'Expand Always'),
        (ON_CLICK, 'Expand on Click'),
    ]
