import segno
from django.contrib.auth.mixins import LoginRequiredMixin
from django.utils.safestring import mark_safe
from django.views.generic import View
from django.shortcuts import render, redirect, get_object_or_404
import logging
from django.conf import settings
from django.utils.http import url_has_allowed_host_and_scheme
from django.urls import reverse
from django.http import HttpResponseRedirect
from django.contrib.auth import login as auth_login, logout as auth_logout, update_session_auth_hash
from django_otp import devices_for_user
from django_otp.models import Device
from django_otp.plugins.otp_totp.models import TOTPDevice
from django_otp.plugins.otp_static.models import StaticToken, StaticDevice
from otp_yubikey.models import RemoteYubikeyDevice

from extras.models import ObjectChange
from extras.tables import ObjectChangeTable
from statuspage.config import get_config
from users.forms import LoginForm, UserConfigForm, PasswordChangeForm, TokenForm, TwoFactorDeviceSelectForm,\
    TwoFactorTOTPForm, TwoFactorYubikeyForm
from django.contrib import messages

from users.models import UserConfig, Token
from users.tables import TokenTable, TwoFactorTable
from utilities.forms import ConfirmationForm


class LoginView(View):
    template_name = 'login.html'

    def get(self, request):
        form = LoginForm(request)

        if request.user.is_authenticated:
            logger = logging.getLogger('statuspage.auth.login')
            return self.redirect_to_next(request, logger)

        return render(request, self.template_name, {
            'form': form,
        })

    def post(self, request):
        logger = logging.getLogger('statuspage.auth.login')
        form = LoginForm(request, data=request.POST)

        otp_device_id = request.POST.get('otp-device')
        otp_token = request.POST.get('otp-token')

        if form.is_valid():
            logger.debug("Login form validation was successful")

            user = form.get_user()

            devices = list(devices_for_user(user=user))
            totp_devices = list(TOTPDevice.objects.devices_for_user(user=user, confirmed=True))

            if len(totp_devices) > 0 and otp_device_id is None and otp_token is None:
                first_device = totp_devices[0]
                messages.warning(request, 'Please enter a OTP Token.')
                new_form = LoginForm(request, initial=request.POST)
                return render(request, self.template_name, {
                    'form': new_form,
                    'totp_devices': devices,
                    'selected_device': first_device.persistent_id,
                })

            if otp_device_id is not None and otp_token is not None:
                first_device = totp_devices[0]
                otp_device = Device.from_persistent_id(otp_device_id)
                if not otp_device.user == user or not otp_device.verify_token(otp_token):
                    messages.error(request, 'Please enter a valid OTP Token.')
                    new_form = LoginForm(request, initial=request.POST)
                    return render(request, self.template_name, {
                        'form': new_form,
                        'totp_devices': devices,
                        'selected_device': first_device.persistent_id,
                    })

            # Authenticate user
            auth_login(request, user)
            logger.info(f"User {request.user} successfully authenticated")
            messages.info(request, f"Logged in as {request.user}.")

            # Ensure the user has a UserConfig defined. (This should normally be handled by
            # create_userconfig() on user creation.)
            if not hasattr(request.user, 'config'):
                config = get_config()
                UserConfig(user=request.user, data=config.DEFAULT_USER_PREFERENCES).save()

            return self.redirect_to_next(request, logger)

        else:
            logger.debug("Login form validation failed")

        return render(request, self.template_name, {
            'form': form,
        })

    def redirect_to_next(self, request, logger):
        data = request.POST if request.method == "POST" else request.GET
        redirect_url = data.get('next', settings.LOGIN_REDIRECT_URL)

        if redirect_url and url_has_allowed_host_and_scheme(redirect_url, allowed_hosts=None):
            logger.debug(f"Redirecting user to {redirect_url}")
        else:
            if redirect_url:
                logger.warning(f"Ignoring unsafe 'next' URL passed to login form: {redirect_url}")
            redirect_url = reverse('home')

        return HttpResponseRedirect(redirect_url)


class LogoutView(View):
    """
    Deauthenticate a web user.
    """

    def get(self, request):
        logger = logging.getLogger('statuspage.auth.logout')

        # Log out the user
        username = request.user
        auth_logout(request)
        logger.info(f"User {username} has logged out")
        messages.info(request, "You have logged out.")

        # Delete session key cookie (if set) upon logout
        response = HttpResponseRedirect(reverse('home'))
        response.delete_cookie('session_key')

        return response


class ProfileView(LoginRequiredMixin, View):
    template_name = 'users/profile.html'

    def get(self, request):
        # Compile changelog table
        changelog = ObjectChange.objects.restrict(request.user, 'view').filter(user=request.user).prefetch_related(
            'changed_object_type'
        )[:20]
        changelog_table = ObjectChangeTable(changelog)

        return render(request, self.template_name, {
            'changelog_table': changelog_table,
        })


class UserConfigView(LoginRequiredMixin, View):
    template_name = 'users/preferences.html'

    def get(self, request):
        userconfig = request.user.config
        form = UserConfigForm(instance=userconfig)

        return render(request, self.template_name, {
            'form': form,
        })

    def post(self, request):
        userconfig = request.user.config
        form = UserConfigForm(request.POST, instance=userconfig)

        if form.is_valid():
            form.save()

            messages.success(request, "Your preferences have been updated.")
            return redirect('users:preferences')

        return render(request, self.template_name, {
            'form': form,
        })


class ChangePasswordView(LoginRequiredMixin, View):
    template_name = 'users/password.html'

    def get(self, request):
        form = PasswordChangeForm(user=request.user)

        return render(request, self.template_name, {
            'form': form,
        })

    def post(self, request):
        form = PasswordChangeForm(user=request.user, data=request.POST)
        if form.is_valid():
            form.save()
            update_session_auth_hash(request, form.user)
            messages.success(request, "Your password has been changed successfully.")
            return redirect('users:profile')

        return render(request, self.template_name, {
            'form': form,
        })


class TokenListView(LoginRequiredMixin, View):

    def get(self, request):

        tokens = Token.objects.filter(user=request.user)
        table = TokenTable(tokens)
        table.configure(request)

        return render(request, 'users/api_tokens.html', {
            'model': tokens.model,
            'tokens': tokens,
            'table': table,
        })


class TokenEditView(LoginRequiredMixin, View):

    def get(self, request, pk=None):

        if pk:
            token = get_object_or_404(Token.objects.filter(user=request.user), pk=pk)
        else:
            token = Token(user=request.user)

        form = TokenForm(instance=token)

        return render(request, 'generic/object_edit.html', {
            'object': token,
            'form': form,
            'return_url': reverse('users:token_list'),
        })

    def post(self, request, pk=None):

        if pk:
            token = get_object_or_404(Token.objects.filter(user=request.user), pk=pk)
            form = TokenForm(request.POST, instance=token)
        else:
            token = Token(user=request.user)
            form = TokenForm(request.POST)

        if form.is_valid():
            token = form.save(commit=False)
            token.user = request.user
            token.save()

            msg = f"Modified token {token}" if pk else f"Created token {token}"
            messages.success(request, msg)

            if '_addanother' in request.POST:
                return redirect(request.path)
            else:
                return redirect('users:token_list')

        return render(request, 'generic/object_edit.html', {
            'object': token,
            'form': form,
            'return_url': reverse('users:token_list'),
        })


class TokenDeleteView(LoginRequiredMixin, View):

    def get(self, request, pk):

        token = get_object_or_404(Token.objects.filter(user=request.user), pk=pk)
        initial_data = {
            'return_url': reverse('users:token_list'),
        }
        form = ConfirmationForm(initial=initial_data)

        return render(request, 'generic/object_delete.html', {
            'object': token,
            'form': form,
            'return_url': reverse('users:token_list'),
        })

    def post(self, request, pk):

        token = get_object_or_404(Token.objects.filter(user=request.user), pk=pk)
        form = ConfirmationForm(request.POST)
        if form.is_valid():
            token.delete()
            messages.success(request, "Token deleted")
            return redirect('users:token_list')

        return render(request, 'generic/object_delete.html', {
            'object': token,
            'form': form,
            'return_url': reverse('users:token_list'),
        })


def get_model_and_form(device_type):
    device_types = {
        'totp': (TOTPDevice, TwoFactorTOTPForm),
        'yubikey': (RemoteYubikeyDevice, TwoFactorYubikeyForm),
        'static': (StaticDevice, TwoFactorTOTPForm),
    }
    if device_type not in device_types:
        return None
    return device_types[device_type]


class TwoFactorBackupCodesListView(LoginRequiredMixin, View):

    def get(self, request, pk):
        device = get_object_or_404(StaticDevice.objects.filter(user=request.user), pk=pk)

        if device.confirmed:
            messages.error(request, 'You have already viewed your Backup Codes.')
            return redirect('users:device_list')

        device.confirmed = True
        device.save()
        backup_codes = device.token_set.all()

        return render(request, 'users/two_factor_backup_codes.html', {
            'device': device,
            'backup_codes': backup_codes,
        })


class TwoFactorQRCodeListView(LoginRequiredMixin, View):

    def get(self, request, pk):
        device = get_object_or_404(TOTPDevice.objects.filter(user=request.user), pk=pk)

        if device.confirmed:
            messages.error(request, 'You have already viewed the QR Code.')
            return redirect('users:device_list')

        qr_code = segno.make_qr(device.config_url).svg_inline(omitsize=True)

        return render(request, 'users/two_factor_qr_code.html', {
            'device': device,
            'qr_code': mark_safe(qr_code),
            'config_url': device.config_url,
        })

    def post(self, request, pk):
        device = get_object_or_404(TOTPDevice.objects.filter(user=request.user), pk=pk)
        token = request.POST.get('token')

        if device.confirmed:
            messages.error(request, 'You have already viewed the QR Code.')
            return redirect('users:device_list')

        qr_code = segno.make_qr(device.config_url).svg_inline(omitsize=True)

        if not device.verify_is_allowed():
            messages.error(request, 'Verify not allowed.')
            return render(request, 'users/two_factor_qr_code.html', {
                'device': device,
                'qr_code': mark_safe(qr_code),
                'config_url': device.config_url,
            })

        if not device.verify_token(token=token):
            messages.error(request, 'Wrong Token provided.')
            return render(request, 'users/two_factor_qr_code.html', {
                'device': device,
                'qr_code': mark_safe(qr_code),
                'config_url': device.config_url,
            })

        device.confirmed = True
        device.save()
        messages.success(request, f'{device.name} successfully verified.')
        return redirect('users:device_list')


class TwoFactorListView(LoginRequiredMixin, View):

    def get(self, request):

        devices = devices_for_user(user=request.user, confirmed=None)
        table = TwoFactorTable(devices)
        table.configure(request)
        form = TwoFactorDeviceSelectForm()

        device_list = StaticDevice.objects.filter(user=request.user)

        return render(request, 'users/two_factor.html', {
            'form': form,
            'tokens': devices,
            'table': table,
            'show_generate_backup_codes': len(device_list) == 0,
        })

    def post(self, request):
        action = request.POST.get('action')
        if 'generate_backup_codes' not in action:
            return redirect('users:device_list')

        device_list = StaticDevice.objects.filter(user=request.user)

        if len(device_list) == 0:
            device = StaticDevice()
            device.confirmed = False
            device.user = request.user
            device.name = 'Backup Codes'
            device.save()
        elif len(device_list) == 1:
            messages.error(request, 'Your backup Codes are already generated! Delete the existing ones,'
                                    'if you want to generate new ones!')
            return redirect('users:device_list')
        else:
            return redirect('users:device_list')

        for i in range(0, 8):
            token = StaticToken()
            token.device = device
            token.token = token.random_token()
            token.save()

        messages.success(request, 'Successfully generated new Backup Codes. Click on "View" to see and enable them.')
        return redirect('users:device_list')


class TwoFactorEditView(LoginRequiredMixin, View):
    def get(self, request, pk=None):
        device_type = request.GET.get('device_type')
        device_model_and_form = get_model_and_form(device_type)
        if not device_type and not device_model_and_form:
            return redirect('users:device_list')

        (device_model, device_form) = device_model_and_form

        if pk:
            device = get_object_or_404(device_model.objects.filter(user=request.user), pk=pk)
        else:
            device = device_model(user=request.user)

        form = device_form(instance=device, initial={
            'device_type': device_type,
        })

        return render(request, 'generic/object_edit.html', {
            'object': device,
            'form': form,
            'return_url': reverse('users:device_list'),
        })

    def post(self, request, pk=None):
        device_type = request.POST.get('device_type')
        device_model_and_form = get_model_and_form(device_type)
        if not device_type and not device_model_and_form:
            return redirect('users:device_list')

        (device_model, device_form) = device_model_and_form

        if pk:
            device = get_object_or_404(device_model.objects.filter(user=request.user), pk=pk)
            form = device_form(request.POST, instance=device)
        else:
            device = device_model(user=request.user)
            form = device_form(request.POST)

        if form.is_valid():
            device = form.save(commit=False)
            device.user = request.user
            if not pk:
                device.confirmed = False
            device.save()

            msg = f"Modified Device {device}" if pk else f"Created Device {device}"
            messages.success(request, msg)

            if '_addanother' in request.POST:
                return redirect(request.path)
            else:
                return redirect('users:device_list')

        return render(request, 'generic/object_edit.html', {
            'object': device,
            'form': form,
            'return_url': reverse('users:token_list'),
        })


class TwoFactorDeleteView(LoginRequiredMixin, View):

    def get(self, request, pk):
        device_type = request.GET.get('device_type')
        device_model_and_form = get_model_and_form(device_type)
        if not device_type and not device_model_and_form:
            return redirect('users:device_list')

        (device_model,_) = device_model_and_form

        device = get_object_or_404(device_model.objects.filter(user=request.user), pk=pk)
        initial_data = {
            'return_url': reverse('users:device_list'),
        }
        form = ConfirmationForm(initial=initial_data)

        return render(request, 'generic/object_delete.html', {
            'object': device,
            'form': form,
            'return_url': reverse('users:device_list'),
        })

    def post(self, request, pk):
        device_type = request.GET.get('device_type')
        device_model_and_form = get_model_and_form(device_type)
        if not device_type and not device_model_and_form:
            return redirect('users:device_list')

        (device_model,_) = device_model_and_form

        device = get_object_or_404(device_model.objects.filter(user=request.user), pk=pk)
        form = ConfirmationForm(request.POST)
        if form.is_valid():
            device.delete()
            messages.success(request, "Device deleted")
            return redirect('users:device_list')

        return render(request, 'generic/object_delete.html', {
            'object': device,
            'form': form,
            'return_url': reverse('users:device_list'),
        })
