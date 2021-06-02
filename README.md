<div align="center">
    <img alt="Status Page" src="https://cdn.herrtxbias.net/status-page/logo_gray/logo_small.png"></a>
</div>
<br />
<p align="center">
    <a href="https://github.com/Status-Page/Status-Page"><img alt="GitHub license" src="https://img.shields.io/github/license/Status-Page/Status-Page"></a>
    <a href="https://github.com/Status-Page/Status-Page/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/Status-Page/Status-Page"></a>
    <a href="https://github.com/Status-Page/Status-Page/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/Status-Page/Status-Page"></a>
    <a href="https://github.com/Status-Page/Status-Page/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/Status-Page/Status-Page"></a>
    <a href="https://github.com/Status-Page/Status-Page/releases"><img alt="GitHub latest releas" src="https://img.shields.io/github/release/Status-Page/Status-Page"></a>
    <a href="https://www.codacy.com/gh/Status-Page/Status-Page/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Status-Page/Status-Page&amp;utm_campaign=Badge_Grade"><img src="https://app.codacy.com/project/badge/Grade/250b53ad99ca432cbac8d761a975b34d"/></a>
</p>

# Overview
- Components
- Report incidents
- JSON API
- Metrics
- Two factor authentication
- Markdown support in incident / maintenance messages
- And soon more...

# Requirements
- HTTP server with PHP support (e.g.: Apache, Nginx)
- PHP 8.0 (minimum: PHP 7.4)
- Composer
- A supported database: MySQL, PostgreSQL or SQLite
- Mail Server (with SMTP)
- Optional, but recommended:
    - Redis Server
    - supervisor

# Installation
``` shell
git clone https://github.com/Status-Page/Status-Page
cd status-page
git checkout $(git describe --tags `git rev-list --tags --max-count=1`)
composer install
npm install
cp .env.example .env
```
Now edit the .env and fill it with your data in.
``` shell
php artisan status:install
```
Make sure the user of your webserver has write rights to the directories here.

After the installation is complete, you can access the Dashboard via the route `/dashboard`.

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
If you update using git-tags (default and recommended): Run ``php artisan status:update --tags``.

If you update using git-pull on the master branch: Run ``php artisan status:update``.
This will handle all necessary operations, as well as the git-pull.

### Manual updating
``` shell
php artisan down
git fetch origin
git tag -l
git checkout LATEST_TAG              # Insert the Latest Tag for LATEST_TAG
composer install --no-dev -o --no-scripts
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## Documentation
You can find the Documentation [here](https://status-page-docs.netlify.app/).

## Translation
If you want to help with translation, head over to [my translation page](https://translate.herrtxbias.net/projects/status-page/).

Translation Status:

<a href="http://translate.herrtxbias.net/engage/status-page/">
<img src="http://translate.herrtxbias.net/widgets/status-page/-/multi-auto.svg" alt="Translation status" />
</a>

## Running queued Jobs
To run queued Jobs you should use [supervisor](https://laravel.com/docs/8.x/queues#supervisor-configuration).

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

## Available Import Scripts
### Requirements
- Node.JS


### Import from statuspage.io
You can import your components from statuspage.io, with a simple script.
To use it, run the following command:
``` shell
npm run statuspage-import
```

### Import from Cachet
You can import your components from Cachet, with a simple script.
To use it, run the following command:
``` shell
npm run cachet-import
```

## Other Licenses
### Tailwind UI
We are using Tailwind UI Components in this App. You are **NOT** allowed to reuse these Components in your own App!

See their [License](https://www.notion.so/Tailwind-UI-License-644418bb34ad4fa29aac9b82e956a867) for more information.
