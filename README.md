# Requirements
- PHP 7.4 (Recommended: PHP 8.0)
- Database (e.g. MySQL)
- Mail Service (e.g. SMTP Server)
- Redis Server (for caching and queueing)

# Installation
``` shell
git clone https://git.herrtxbias.net/herrtxbias/status-page
cd status-page
composer install
npm install
npm run dev
cp .env.example .env
```
Now edit the .env and fill it with your data.
```
php artisan status:install
```

## After install
- Add the Command, shown in the installer to your crontab! Otherwise Scheduled Maintenances and much more won't work.

## Adding new Users
Currently it is only possible to add a new User via the command: ``php artisan status:adduser``
