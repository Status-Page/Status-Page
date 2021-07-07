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
This section has been moved to our [Documentation](https://status-page-docs.netlify.app/docs/main/installation/installing)

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
### Updating
This section has been moved to our [Documentation](https://status-page-docs.netlify.app/docs/main/installation/upgrading#the-easy-way)

### Manual updating
This section has been moved to our [Documentation](https://status-page-docs.netlify.app/docs/main/installation/upgrading#the-hard-way)

## Documentation
You can find the Documentation [here](https://status-page-docs.netlify.app/).

## Translation
If you want to help with translation, head over to [my translation page](https://translate.herrtxbias.net/projects/status-page/).

Translation Status:

<a href="http://translate.herrtxbias.net/engage/status-page/">
<img src="http://translate.herrtxbias.net/widgets/status-page/-/multi-auto.svg" alt="Translation status" />
</a>

## Running queued Jobs
This section has been moved to our [Documentation](https://status-page-docs.netlify.app/docs/main/setup/configuring-queue)

## Available Import Scripts
### Requirements
- Node.JS

**Note:** You should enable the [Migration Mode](https://github.com/Status-Page/Status-Page/blob/bdeae330a40c88c33d85cd20063cca4a01f66730/.env.example#L15)!

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
