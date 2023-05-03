import datetime

from django.utils import formats
from pysvg.builders import StyleBuilder
from pysvg.shape import Rect

from statuspage import settings


class ExtendedRect(Rect):
    def set_data_tooltip(self, tooltip):
        self._attributes['data-tooltip'] = tooltip

    def get_data_tooltip(self):
        return self._attributes.get('data-tooltip')


def create_rect(index, fill='none', date=datetime.datetime.today(), incidents=0):
    style_dict = {'fill': fill}
    style = StyleBuilder(style_dict)
    r = ExtendedRect(x=index * 9, y=0, width=5, height=32, data_tooltip=f"{formats.date_format(date)}<br>Incident amount: {incidents}")
    r.set_style(style.getStyle())
    return r
