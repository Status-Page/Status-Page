# Status-Page Installation

## Install System Packages

Begin by installing all system packages required by Status-Page and its dependencies.

!!! warning "Python 3.10 or later required"
    Status-Page requires Python 3.10 or later.

=== "Ubuntu"

    ```no-highlight
    sudo apt install -y python3 python3-pip python3-venv python3-dev build-essential libxml2-dev libxslt1-dev libffi-dev libpq-dev libssl-dev zlib1g-dev
    ```

=== "CentOS"

    ```no-highlight
    sudo yum install -y gcc libxml2-devel libxslt-devel libffi-devel libpq-devel openssl-devel redhat-rpm-config
    ```

Before continuing, check that your installed Python version is at least 3.10:

```no-highlight
python3 -V
```

## Download Status-Page

Create the base directory for the installation. We'll use `/opt/status-page` for now.

```no-highlight
sudo mkdir -p /opt/status-page/
cd /opt/status-page/
```

If `git` is not already installed, install it:

=== "Ubuntu"

    ```no-highlight
    sudo apt install -y git
    ```

=== "CentOS"

    ```no-highlight
    sudo yum install -y git
    ```

Next, clone the Status-Page GitHub repository into the current directory. (Note that this will always pull the main branch, which may be unstable)

```no-highlight
sudo git clone https://github.com/status-page/status-page.git .
```

The `git clone` command should generate output similar to the following:

```no-highlight
Cloning into '.'...
remote: Enumerating objects: 426, done.
remote: Counting objects: 100% (426/426), done.
remote: Compressing objects: 100% (361/361), done.
remote: Total 426 (delta 49), reused 366 (delta 43), pack-reused 0
Receiving objects: 100% (426/426), 2.68 MiB | 9.44 MiB/s, done.
Resolving deltas: 100% (49/49), done.
```

You now need to select a version, which you want to run. Type the following command, to check out the latest release.

```no-highlight
sudo git checkout $(git describe --tags `git rev-list --tags --max-count=1`)
```

!!! note
    To check out a [specific release](https://github.com/status-page/status-page/releases), use the `git checkout` command with the desired release tag. For example, `git checkout v2.0.0`.

## Create the Status-Page System User

Create a system user account named `status-page`. We'll configure the WSGI and HTTP services to run under this account.

=== "Ubuntu"

    ```
    sudo adduser --system --group status-page
    ```

=== "CentOS"

    ```
    sudo groupadd --system status-page
    sudo adduser --system -g status-page status-page
    ```

## Configuration

Move into the Status-Page configuration directory and make a copy of `configuration_example.py` named `configuration.py`. This file will hold all of your local configuration parameters.

```no-highlight
cd /opt/status-page/statuspage/statuspage/
sudo cp configuration_example.py configuration.py
```

Open `configuration.py` with your preferred editor to begin configuring Status-Page. Status-Page offers many configuration parameters, but only the following four are required for new installations:

* `ALLOWED_HOSTS`
* `DATABASE`
* `REDIS`
* `SECRET_KEY`

### ALLOWED_HOSTS

This is a list of the valid hostnames and IP addresses by which this server can be reached. You must specify at least one name or IP address. (Note that this does not restrict the locations from which Status-Page may be accessed: It is merely for [HTTP host header validation](https://docs.djangoproject.com/en/3.0/topics/security/#host-headers-virtual-hosting).)

```python
ALLOWED_HOSTS = ['status-page.example.com', '192.0.2.123']
```

If you are not yet sure what the domain name and/or IP address of the Status-Page installation will be, you can set this to a wildcard (asterisk) to allow all host values:

```python
ALLOWED_HOSTS = ['*']
```

### DATABASE

This parameter holds the database configuration details. You must define the username and password used when you configured PostgreSQL. If the service is running on a remote host, update the `HOST` and `PORT` parameters accordingly. See the configuration documentation for more detail on individual parameters.

```python
DATABASE = {
    'NAME': 'status-page',          # Database name
    'USER': 'status-page',          # PostgreSQL username
    'PASSWORD': 'abcdefgh123456',   # PostgreSQL password
    'HOST': 'localhost',            # Database server
    'PORT': '',                     # Database port (leave blank for default)
    'CONN_MAX_AGE': 300,            # Max database connection age (seconds)
}
```

### REDIS

Redis is a in-memory key-value store used by Status-Page for caching and background task queuing. Redis typically requires minimal configuration; the values below should suffice for most installations. See the configuration documentation for more detail on individual parameters.

Note that Status-Page requires the specification of two separate Redis databases: `tasks` and `caching`. These may both be provided by the same Redis service, however each should have a unique numeric database ID.

```python
REDIS = {
    'tasks': {
        'HOST': 'localhost',      # Redis server
        'PORT': 6379,             # Redis port
        'PASSWORD': '',           # Redis password (optional)
        'DATABASE': 0,            # Database ID
        'SSL': False,             # Use SSL (optional)
    },
    'caching': {
        'HOST': 'localhost',
        'PORT': 6379,
        'PASSWORD': '',
        'DATABASE': 1,            # Unique ID for second database
        'SSL': False,
    }
}
```

### SECRET_KEY

This parameter must be assigned a randomly-generated key employed as a salt for hashing and related cryptographic functions. (Note, however, that it is _never_ directly used in the encryption of secret data.) This key must be unique to this installation and is recommended to be at least 50 characters long. It should not be shared outside the local system.

A simple Python script named `generate_secret_key.py` is provided in the parent directory to assist in generating a suitable key:

```no-highlight
python3 ../generate_secret_key.py
```

!!! warning "SECRET_KEY values must match"
    In the case of a highly available installation with multiple web servers, `SECRET_KEY` must be identical among all servers in order to maintain a persistent user session state.

When you have finished modifying the configuration, remember to save the file.

## Optional Requirements

All Python packages required by Status-Page are listed in `requirements.txt` and will be installed automatically. Status-Page also supports some optional packages. If desired, these packages must be listed in `local_requirements.txt` within the Status-Page root directory.

## Run the Installation and Upgrade Script

Once Status-Page has been configured, we're ready to proceed with the actual installation. We'll run the packaged upgrade script (`upgrade.sh`) to perform the following actions:

* Create a Python virtual environment
* Installs all required Python packages
* Run database schema migrations
* Builds the documentation locally (for offline use)
* Aggregate static resource files on disk

```no-highlight
sudo /opt/status-page/upgrade.sh
```

Note that **Python 3.10 or later is required** for Status-Page v2.0 and later releases. If the default Python installation on your server is set to a lesser version, pass the path to the supported installation as an environment variable named `PYTHON`. (Note that the environment variable must be passed _after_ the `sudo` command.)

```no-highlight
sudo PYTHON=/usr/bin/python3.10 /opt/status-page/upgrade.sh
```

!!! note
    Upon completion, the upgrade script may warn that no existing virtual environment was detected. As this is a new installation, this warning can be safely ignored.

## Create a Super User

Status-Page does not come with any predefined user accounts. You'll need to create a super user (administrative account) to be able to log into Status-Page. First, enter the Python virtual environment created by the upgrade script:

```no-highlight
source /opt/status-page/venv/bin/activate
```

Once the virtual environment has been activated, you should notice the string `(venv)` prepended to your console prompt.

Next, we'll create a superuser account using the `createsuperuser` Django management command (via `manage.py`). Specifying an email address for the user is not required, but be sure to use a very strong password.

```no-highlight
cd /opt/status-page/statuspage
python3 manage.py createsuperuser
```

## Test the Application

At this point, we should be able to run Status-Page's development server for testing. We can check by starting a development instance:

```no-highlight
python3 manage.py runserver 0.0.0.0:8000 --insecure
```

If successful, you should see output similar to the following:

```no-highlight
Watching for file changes with StatReloader
Performing system checks...

System check identified no issues (0 silenced).
August 30, 2021 - 18:02:23
Django version 3.2.6, using settings 'statuspage.settings'
Starting development server at http://127.0.0.1:8000/
Quit the server with CONTROL-C.
```

Next, connect to the name or IP of the server (as defined in `ALLOWED_HOSTS`) on port 8000; for example, <http://127.0.0.1:8000/dashboard/>. You should be greeted with the Status-Page login page. Try logging in using the username and password specified when creating a superuser.

!!! note
    By default RHEL based distros will likely block your testing attempts with firewalld. The development server port can be opened with `firewall-cmd` (add `--permanent` if you want the rule to survive server restarts):

    ```no-highlight
    firewall-cmd --zone=public --add-port=8000/tcp
    ```

!!! danger "Not for production use"
    The development server is for development and testing purposes only. It is neither performant nor secure enough for production use. **Do not use it in production.**

!!! warning
    If the test service does not run, or you cannot reach the Status-Page home page, something has gone wrong. Do not proceed with the rest of this guide until the installation has been corrected.

Type `Ctrl+c` to stop the development server.
