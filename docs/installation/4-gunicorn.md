# Gunicorn

Like most Django applications, Status-Page runs as a [WSGI application](https://en.wikipedia.org/wiki/Web_Server_Gateway_Interface) behind an HTTP server. This documentation shows how to install and configure [gunicorn](http://gunicorn.org/) (which is automatically installed with Status-Page) for this role, however other WSGI servers are available and should work similarly well.

## Configuration

Status-Page ships with a default configuration file for gunicorn. To use it, copy `/opt/status-page/contrib/gunicorn.py` to `/opt/status-page/gunicorn.py`. (We make a copy of this file rather than pointing to it directly to ensure that any local changes to it do not get overwritten by a future upgrade.)

```no-highlight
sudo cp /opt/status-page/contrib/gunicorn.py /opt/status-page/gunicorn.py
```

While the provided configuration should suffice for most initial installations, you may wish to edit this file to change the bound IP address and/or port number, or to make performance-related adjustments. See [the Gunicorn documentation](https://docs.gunicorn.org/en/stable/configure.html) for the available configuration parameters.

## systemd Setup

We'll use systemd to control gunicorn, Status-Page's background worker scheduler and Status-Page's background worker process. First, copy `contrib/status-page.service`, `contrib/status-page-scheduler.service` and `contrib/status-page-rq.service` to the `/etc/systemd/system/` directory and reload the systemd daemon:

```no-highlight
sudo cp -v /opt/status-page/contrib/*.service /etc/systemd/system/
sudo systemctl daemon-reload
```

Then, start the `status-page`, `status-page-scheduler` and `status-page-rq` services and enable them to initiate at boot time:

```no-highlight
sudo systemctl start status-page status-page-scheduler status-page-rq
sudo systemctl enable status-page status-page-scheduler status-page-rq
```

You can use the command `systemctl status status-page` to verify that the WSGI service is running:

```no-highlight
systemctl status status-page.service
```

You should see output similar to the following:

```no-highlight
● status-page.service - Status-Page WSGI Service
     Loaded: loaded (/etc/systemd/system/status-page.service; enabled; vendor preset: enabled)
     Active: active (running) since Mon 2022-10-30 17:54:22 UTC; 14h ago
       Docs: https://docs.status-page.dev/
   Main PID: 1573 (gunicorn)
      Tasks: 19 (limit: 4683)
     Memory: 666.2M
     CGroup: /system.slice/status-page.service
             ├─1573 /opt/status-page/venv/bin/python3 /opt/status-page/venv/bin/gunicorn >
             ├─1579 /opt/status-page/venv/bin/python3 /opt/status-page/venv/bin/gunicorn >
             ├─1584 /opt/status-page/venv/bin/python3 /opt/status-page/venv/bin/gunicorn >
...
```

!!! note
    If the Status-Page service fails to start, issue the command `journalctl -eu status-page` to check for log messages that may indicate the problem.

Once you've verified that the WSGI workers are up and running, move on to HTTP server setup.
