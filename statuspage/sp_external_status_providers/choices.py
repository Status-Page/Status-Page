from utilities.choices import ChoiceSet


class ExternalStatusPageProviderChoices(ChoiceSet):
    key = 'ExternalStatusPage.provider'

    ATLASSIAN_STATUSPAGE = 'atlassian-statuspage'

    CHOICES = [
        (ATLASSIAN_STATUSPAGE, 'Atlassian Statuspage'),
    ]
