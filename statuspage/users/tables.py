from django_otp.models import Device
import django_tables2 as tables

from .models import Token
from statuspage.tables import StatusPageTable, columns

__all__ = (
    'TokenTable',
    'TwoFactorTable',
)


TOKEN = """<samp><span id="token_{{ record.pk }}">{{ value }}</span></samp>"""

ALLOWED_IPS = """{{ value|join:", " }}"""

COPY_BUTTON = """
<a class="px-2 py-1 rounded-md bg-green-500 hover:bg-green-400 copy-token" data-clipboard-target="#token_{{ record.pk }}" title="Copy to clipboard">
  <i class="mdi mdi-content-copy"></i>
</a>
"""


class TokenTable(StatusPageTable):
    key = columns.TemplateColumn(
        template_code=TOKEN
    )
    write_enabled = columns.BooleanColumn(
        verbose_name='Write'
    )
    created = columns.DateColumn()
    expired = columns.DateColumn()
    last_used = columns.DateTimeColumn()
    allowed_ips = columns.TemplateColumn(
        template_code=ALLOWED_IPS
    )
    actions = columns.ActionsColumn(
        actions=('edit', 'delete'),
        extra_buttons=COPY_BUTTON
    )

    class Meta(StatusPageTable.Meta):
        model = Token
        fields = (
            'pk', 'key', 'write_enabled', 'created', 'expires', 'last_used', 'allowed_ips', 'description',
        )


TWO_FACTOR_TEMPLATES = """
{% if record.token_set %}
<div>{{ record.token_set.all|length }} Codes left</div>
{% endif %}
{% if not record.confirmed %}
<div>Click the Eye to confirm</div>
{% endif %}
"""

TWO_FACTOR_ACTIONS = """
{% if record.token_set %}
{% if not record.confirmed %}
<a href="{% url 'users:device_backup_codes' pk=record.pk %}" class="px-2 py-1 rounded-md bg-blue-500 hover:bg-blue-400">
  <i class="mdi mdi-eye"></i>
</a>
{% endif %}
<a href="{% url 'users:device_delete' pk=record.pk %}?device_type=static" class="px-2 py-1 rounded-md bg-red-500 hover:bg-red-400">
  <i class="mdi mdi-trash-can-outline"></i>
</a>
{% endif %}
{% if record.private_id %}
<a href="{% url 'users:device_delete' pk=record.pk %}?device_type=yubikey" class="px-2 py-1 rounded-md bg-red-500 hover:bg-red-400">
  <i class="mdi mdi-trash-can-outline"></i>
</a>
{% endif %}
{% if record.digits %}
{% if not record.confirmed %}
<a href="{% url 'users:device_qr_code' pk=record.pk %}" class="px-2 py-1 rounded-md bg-blue-500 hover:bg-blue-400">
  <i class="mdi mdi-eye"></i>
</a>
{% endif %}
<a href="{% url 'users:device_delete' pk=record.pk %}?device_type=totp" class="px-2 py-1 rounded-md bg-red-500 hover:bg-red-400">
  <i class="mdi mdi-trash-can-outline"></i>
</a>
{% endif %}
"""


class TwoFactorTable(StatusPageTable):
    name = tables.Column()
    confirmed = columns.BooleanColumn()
    info = columns.TemplateColumn(
        template_code=TWO_FACTOR_TEMPLATES,
        verbose_name='Information',
    )
    actions = columns.ActionsColumn(
        actions=(),
        extra_buttons=TWO_FACTOR_ACTIONS,
    )

    class Meta(StatusPageTable.Meta):
        model = Device
        fields = (
            'pk', 'name', 'info', 'confirmed', 'actions'
        )
