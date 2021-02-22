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
Now edit the .env and fill it with your data.in
```
php artisan status:install
```
Make sure the user of your webserver has write rights to the directories here.

### Known issues
1. ``Invalid route action: [C:32:"Opis\Closure\SerializableClosure":210.....``
    - Solution: Run Command ``php artisan route:clear && php artisan route:cache``

## After install
- Add the Command, shown in the installer to your crontab! Otherwise Scheduled Maintenances and much more won't work.

## Adding new Users
Currently it is only possible to add a new User via the command: ``php artisan status:adduser``

## Versioning
We use semantic versioning. A version number has the following structure:
````
v 1 . 0 . 0
  ^   ^   ^
  |   |   |
  |   |   Patch (Bug fixes)
  |   |
  |   Minor (No breaking changes to the Software, e.g. adding new features)
  |
  Major (Breaking changes to the Software)
````
If you update using git-tags: Run ``php artisan status:update``.

If you update using git-pull on master: Always remember to run ``php artisan status:updatedatabase`` after pulling a new version.

## API Documentation
You can find the API Documentation [here](https://herrtxbias-status.readme.io/reference).
