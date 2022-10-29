from django.urls import path

from . import views

app_name = 'users'
urlpatterns = [
    path('profile/', views.ProfileView.as_view(), name='profile'),
    path('preferences/', views.UserConfigView.as_view(), name='preferences'),
    path('password/', views.ChangePasswordView.as_view(), name='change_password'),
    path('api-tokens/', views.TokenListView.as_view(), name='token_list'),
    path('api-tokens/add/', views.TokenEditView.as_view(), name='token_add'),
    path('api-tokens/<int:pk>/edit/', views.TokenEditView.as_view(), name='token_edit'),
    path('api-tokens/<int:pk>/delete/', views.TokenDeleteView.as_view(), name='token_delete'),
    path('twofactor/', views.TwoFactorListView.as_view(), name='device_list'),
    path('twofactor/add/', views.TwoFactorEditView.as_view(), name='device_add'),
    path('twofactor/<int:pk>/backup-codes/', views.TwoFactorBackupCodesListView.as_view(), name='device_backup_codes'),
    path('twofactor/<int:pk>/qr-code/', views.TwoFactorQRCodeListView.as_view(), name='device_qr_code'),
    path('twofactor/<int:pk>/edit/', views.TwoFactorEditView.as_view(), name='device_edit'),
    path('twofactor/<int:pk>/delete/', views.TwoFactorDeleteView.as_view(), name='device_delete'),
]
