from django.views.generic import View
from django.shortcuts import redirect, render


class HomeView(View):
    template_name = 'home.html'

    def get(self, request):
        #if not request.user.is_authenticated:
        #    return redirect("login")

        return render(request, self.template_name)
