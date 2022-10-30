# PostgreSQL Installation

If you already have a PostgreSQL database set up, skip to [the next section](2-redis.md).

!!! warning "PostgreSQL 10 or later required"
    Status-Page requires PostgreSQL 10 or later. Please note that other relational databases are **not** supported.

## Installation

=== "Ubuntu"

    ```no-highlight
    sudo apt update
    sudo apt install -y postgresql
    ```

=== "CentOS"

    ```no-highlight
    sudo yum install -y postgresql-server
    sudo postgresql-setup --initdb
    ```

    CentOS configures ident host-based authentication for PostgreSQL by default. Because Status-Page will need to authenticate using a username and password, modify `/var/lib/pgsql/data/pg_hba.conf` to support MD5 authentication by changing `ident` to `md5` for the lines below:

    ```no-highlight
    host    all             all             127.0.0.1/32            md5
    host    all             all             ::1/128                 md5
    ```

Once PostgreSQL has been installed, start the service and enable it to run at boot:

```no-highlight
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

Before continuing, verify that you have installed PostgreSQL 10 or later:

```no-highlight
psql -V
```

## Database Creation

At a minimum, we need to create a database for Status-Page and assign it a username and password for authentication. Start by invoking the PostgreSQL shell as the system Postgres user.

```no-highlight
sudo -u postgres psql
```

Within the shell, enter the following commands to create the database and user (role), substituting your own value for the password:

```postgresql
CREATE DATABASE statuspage;
CREATE USER statuspage WITH PASSWORD 'abcdefgh123456';
GRANT ALL PRIVILEGES ON DATABASE statuspage TO statuspage;
```

!!! danger "Use a strong password"
    **Do not use the password from the example.** Choose a strong, random password to ensure secure database authentication for your Status-Page installation.

Once complete, enter `\q` to exit the PostgreSQL shell.
