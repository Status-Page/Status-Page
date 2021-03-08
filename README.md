<h1 align="center">
    Status Page
</h1>

<p align="center">
    <a href="https://github.com/HerrTxbias/Status-Page"><img alt="GitHub license" src="https://img.shields.io/github/license/HerrTxbias/Status-Page"></a>
    <a href="https://github.com/HerrTxbias/Status-Page/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/HerrTxbias/Status-Page"></a>
    <a href="https://github.com/HerrTxbias/Status-Page/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/HerrTxbias/Status-Page"></a>
    <a href="https://github.com/HerrTxbias/Status-Page/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/HerrTxbias/Status-Page"></a>
    <a href="https://github.com/HerrTxbias/Status-Page/releases"><img alt="GitHub stars" src="https://img.shields.io/github/release/HerrTxbias/Status-Page"></a>
</p>

# Overview
- Components
- Report incidents
- JSON API
- Metrics
- Two factor authentication
- And soon more...

# Requirements
- HTTP server with PHP support (e.g.: Apache, Nginx, Caddy)
- PHP 8.0
- Composer
- A supported database: MySQL, PostgreSQL or SQLite
- Mail Server (e.g. SMTP)
- Optional:
    - Redis Server
    - supervisor

# Installation
``` shell
git clone https://github.com/HerrTxbias/Status-Page
cd status-page
composer install
npm install
npm run dev
cp .env.example .env
```
Now edit the .env and fill it with your data in.
```
php artisan status:install
```
Make sure the user of your webserver has write rights to the directories here.

## After install
- To be able to use all functions like caching etc. you should add the command to your crontab file at the end of the installation.
- Follow the Instructions at "Running queued Jobs"

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
If you update using git-tags: Run ``php artisan status:update --tags``.

If you update using git-pull on the master branch: Run ``php artisan status:update``.
This will handle all necessary operations, as well as the git-pull.

## API Documentation
You can find the API Documentation [here](https://herrtxbias-status.readme.io/reference).

## Translation
If you want to help with translation, head over to [my translation Page](https://translate.herrtxbias.net/projects/status-page/).

## Running queued Jobs
To run queue Jobs you should use [supervisor](https://laravel.com/docs/8.x/queues#supervisor-configuration).

The configuration file (statuspage.conf) for this app would be like this:
```
[program:statuspage]
process_name=%(program_name)s_%(process_num)02d
command=php /PATH/TO/APP/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/SPECIFY/LOG/FOLDER/HERE/worker.log
stopwaitsecs=3600
```
