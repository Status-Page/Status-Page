from utilities.choices import ChoiceSet


class MetricExpandChoices(ChoiceSet):
    key = 'Metric.expand'

    ALWAYS = 'always'
    ON_CLICK = 'on_click'

    CHOICES = [
        (ALWAYS, 'Expand Always'),
        (ON_CLICK, 'Expand on Click'),
    ]


class MetricRangeChoices(ChoiceSet):
    MINUTES_30 = '30m'
    HOURS_1 = '1h'
    HOURS_12 = '12h'
    DAYS_1 = '24h'
    DAYS_2 = '2d'
    DAYS_3 = '3d'
    DAYS_7 = '7d'
    DAYS_30 = '30d'

    CHOICES = [
        (MINUTES_30, '30 Minutes'),
        (HOURS_1, '1 Hour'),
        (HOURS_12, '12 Hours'),
        (DAYS_1, '24 Hours'),
        (DAYS_2, '2 Days'),
        (DAYS_3, '3 Days'),
        (DAYS_7, '7 Days'),
        (DAYS_30, '30 Days'),
    ]
