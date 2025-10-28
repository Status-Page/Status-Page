#!/bin/bash
set -e

# Function to check if Redis is ready
check_redis() {
  python -c "
import sys
import redis
try:
  redis_client = redis.Redis(host='redis', port=6379, socket_connect_timeout=1)
  redis_client.ping()
  print('Redis is ready!')
  sys.exit(0)
except redis.exceptions.ConnectionError:
  print('Redis is not ready yet...')
  sys.exit(1)
"
}

# Function to check if PostgreSQL is ready
check_postgres() {
  python -c "
import sys
import psycopg2
try:
  conn = psycopg2.connect(
    dbname='statuspage',
    user='statuspage',
    password='securepassword',
    host='db',
    port=5432
  )
  conn.close()
  print('PostgreSQL is ready!')
  sys.exit(0)
except psycopg2.OperationalError:
  print('PostgreSQL is not ready yet...')
  sys.exit(1)
"
}

# Wait for Redis to be ready
until check_redis; do
  echo "Waiting for Redis..."
  sleep 2
done

# Wait for PostgreSQL to be ready
until check_postgres; do
  echo "Waiting for PostgreSQL..."
  sleep 2
done

# Generate SECRET_KEY and update configuration.py
echo "Generating SECRET_KEY..."
SECRET_KEY=$(python3 statuspage/generate_secret_key.py)
sed -i "s/SECRET_KEY = ''/SECRET_KEY = '${SECRET_KEY}'/" statuspage/statuspage/configuration.py

# Run migrations
echo "Running migrations..."
python3 statuspage/manage.py migrate --noinput

# Create a superuser (if not already created)
echo "Creating superuser..."

# Check if the superuser already exists
if ! python3 statuspage/manage.py shell -c "from django.contrib.auth.models import User; User.objects.filter(username='admin').exists()" 2>/dev/null; then
  # Create superuser with username "admin" and password "admin"
  echo "Creating superuser..."
  python3 statuspage/manage.py createsuperuser --noinput --username admin --email admin@example.com
  python3 statuspage/manage.py shell -c "from django.contrib.auth.models import User; u=User.objects.get(username='admin'); u.set_password('admin'); u.save()"
else
  echo "Superuser already exists. Skipping creation."
fi

# Collect static files
echo "Collecting static files..."
python3 statuspage/manage.py collectstatic --noinput

# Execute the CMD
echo "Starting application..."
exec "$@"

echo "Collecting static files..."
python3 manage.py collectstatic --noinput

echo "Starting Gunicorn..."
exec gunicorn --workers 3 --bind 0.0.0.0:8000 statuspage.wsgi:application

