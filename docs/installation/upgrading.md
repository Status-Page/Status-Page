# Upgrading

Upgrading Status-Page is pretty simple, however users are cautioned to always review the release notes and save a backup of their current deployment prior to beginning an upgrade.

You can generally upgrade directly to any newer release with no interim steps, with the one exception being incrementing major versions. This can be done only from the most recent _minor_ release of the major version.

!!! warning "Perform a Backup"
    Always be sure to save a backup of your current Status-Page deployment prior to starting the upgrade process.

## 1. Review the Release Notes

Prior to upgrading your Status-Page instance, be sure to carefully review all [release notes](../release-notes/index.md) that have been published since your current version was released. Although the upgrade process typically does not involve additional work, certain releases may introduce breaking or backward-incompatible changes. These are called out in the release notes under the release in which the change went into effect.

## 2. Update Dependencies to Required Versions

Status-Page v2.0 and later require the following:

| Dependency | Minimum Version |
|------------|-----------------|
| Python     | 3.10            |
| PostgreSQL | 10              |
| Redis      | 4.0             |

## 3. Install the Latest Release

You can upgrade Status-Page by checking out the latest tag of the git repository.

This guide assumes that Status-Page is installed at `/opt/status-page`. Pull down the most recent iteration of the master branch:

```no-highlight
cd /opt/status-page
sudo git fetch
sudo git checkout $(git describe --tags `git rev-list --tags --max-count=1`)
```

!!! info "Checking out a specific release"
    To check out a [specific release](https://github.com/status-page/status-page/releases), use the `git checkout` command with the desired release tag. For example, `git checkout v2.0.0`.

## 4. Run the Upgrade Script

Once the new code is in place, verify that any optional Python packages required by your deployment are listed in `local_requirements.txt`. Then, run the upgrade script:

```no-highlight
sudo ./upgrade.sh
```

!!! warning
    If the default version of Python is not at least 3.10, you'll need to pass the path to a supported Python version as an environment variable when calling the upgrade script. For example:

    ```no-highlight
    sudo PYTHON=/usr/bin/python3.10 ./upgrade.sh
    ```

This script performs the following actions:

* Destroys and rebuilds the Python virtual environment
* Installs all required Python packages (listed in `requirements.txt`)
* Installs any additional packages from `local_requirements.txt`
* Applies any database migrations that were included in the release
* Builds the documentation locally (for offline use)
* Collects all static files to be served by the HTTP service
* Deletes stale content types from the database
* Deletes all expired user sessions from the database

!!! note
    If the upgrade script prompts a warning about unreflected database migrations, this indicates that some change has
    been made to your local codebase and should be investigated. Never attempt to create new migrations unless you are
    intentionally modifying the database schema.

## 5. Restart the Status-Page Services

Finally, restart the gunicorn and RQ services:

```no-highlight
sudo systemctl restart status-page status-page-scheduler status-page-rq
```
