from abc import ABC, abstractmethod


class Provider(ABC):
    @abstractmethod
    def get_components(self):
        pass
