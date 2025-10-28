# 🚀 DEPLOYMENT.md - StatusPage Deployment Guide

## 🧭 Purpose
Document the full deployment process of the StatusPage application on an Ubuntu server, including PostgreSQL, Redis, Gunicorn, and Nginx setup.

---

## 🧰 Prerequisites
- Ubuntu server with root access (e.g., AWS EC2)
- Docker not required (manual deployment)
- Port 8000 or 80 open in the security group

---

## 🛠️ 1. PostgreSQL Installation
```bash
sudo apt update
sudo apt install -y postgresql
sudo systemctl start postgresql
sudo systemctl enable postgresql
psql -V
```

## 🗃️ 2. PostgreSQL Database Creation
```bash
sudo -u postgres psql
CREATE USER <your-username>  WITH PASSWORD <your-password> ;
CREATE DATABASE <your-username>  OWNER <your-username> ;
GRANT ALL PRIVILEGES ON DATABASE <your-username>  TO <your-username> ;
\q
```

---

## 📦 3. Redis Installation
```bash
sudo apt install -y redis-server
redis-server -V
```

---

## 📁 4. Clone and Prepare Status-Page
```bash
sudo apt install -y git python3-pip python3-venv python3-dev build-essential libxml2-dev libxslt1-dev libffi-dev libpq-dev libssl-dev zlib1g-dev
sudo mkdir -p /opt/status-page/
cd /opt/status-page/
sudo adduser --system --group <your-username> 
sudo git clone https://github.com/status-page/status-page.git .
python3 -m venv venv
source venv/bin/activate
```

---

## ⚙️ 5. Application Configuration
```bash
cd /opt/status-page/statuspage/statuspage/
sudo cp configuration_example.py configuration.py
sudo nano configuration.py
```
Edit `configuration.py` to match your DB/Redis settings.

Generate secret key:
```bash
python3 ../generate_secret_key.py
```

---

## ⬆️ 6. Upgrade Script
```bash
cd /opt/status-page
sudo vim upgrade.sh  # Make necessary modifications
sudo bash upgrade.sh
```

---

## 👤 7. Superuser Creation
```bash
source venv/bin/activate
cd /opt/status-page/statuspage
python3 manage.py createsuperuser
```
> Username: <your-username>  
> Email: <your-email> 
> Password: <your-password>

---

## 🧪 8. Test Server (Development)
```bash
python3 manage.py runserver 0.0.0.0:8000 --insecure
```
Visit: http://<YOUR-IP>:8000/dashboard/
> Use `Ctrl + C` to stop the server.

---

## 🔥 9. Gunicorn Configuration
```bash
sudo cp /opt/status-page/contrib/gunicorn.py /opt/status-page/gunicorn.py
sudo cp -v /opt/status-page/contrib/*.service /etc/systemd/system/
sudo systemctl daemon-reload
sudo systemctl start status-page status-page-scheduler status-page-rq
sudo systemctl enable status-page status-page-scheduler status-page-rq
systemctl status status-page.service
```

---

## 🌐 10. Nginx & SSL Setup
Generate SSL cert:
```bash
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
-keyout /etc/ssl/private/status-page.key \
-out /etc/ssl/certs/status-page.crt
```

Install & configure Nginx:
```bash
sudo apt install -y nginx
sudo cp /opt/status-page/contrib/nginx.conf /etc/nginx/sites-available/status-page.conf
sudo nano /etc/nginx/sites-available/status-page.conf
```

Enable site:
```bash
sudo rm /etc/nginx/sites-enabled/default
sudo ln -s /etc/nginx/sites-available/status-page.conf /etc/nginx/sites-enabled/status-page.conf
sudo systemctl restart nginx
```

---

## ✅ Done!
Your StatusPage app should now be live on:
```
http://<YOUR-IP>/dashboard/
