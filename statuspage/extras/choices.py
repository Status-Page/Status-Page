from utilities.choices import ChoiceSet

#
# ObjectChanges
#


class ObjectChangeActionChoices(ChoiceSet):

    ACTION_CREATE = 'create'
    ACTION_UPDATE = 'update'
    ACTION_DELETE = 'delete'

    CHOICES = (
        (ACTION_CREATE, 'Created', 'green'),
        (ACTION_UPDATE, 'Updated', 'blue'),
        (ACTION_DELETE, 'Deleted', 'red'),
    )
