FROM python:3.10

WORKDIR /opt/status-page

# Copy application files
COPY requirements.txt .

# Install dependencies directly without using a virtual environment
RUN pip install -r requirements.txt
COPY . .

# Copy base configuration file
RUN cp statuspage/statuspage/configuration_example.py statuspage/statuspage/configuration.py

# Update ALLOWED_HOSTS to allow all hosts
RUN sed -i "s/ALLOWED_HOSTS = .*/ALLOWED_HOSTS = ['*']/" statuspage/statuspage/configuration.py
RUN sed -i "/DATABASE/,/}/s/'HOST': 'localhost'/'HOST': 'db'/" statuspage/statuspage/configuration.py
RUN sed -i "/DATABASE/,/}/s/'PASSWORD': ''/'PASSWORD': 'securepassword'/" statuspage/statuspage/configuration.py
RUN sed -i "/DATABASE/,/}/s/'USER': ''/'USER': 'statuspage'/" statuspage/statuspage/configuration.py

# Update Redis configuration
RUN sed -i "/REDIS/,/}/s/'HOST': 'localhost'/'HOST': 'redis'/" statuspage/statuspage/configuration.py

# Generate SECRET_KEY
RUN python3 statuspage/generate_secret_key.py

# Open the application port
EXPOSE 8000

# Make scripts executable
RUN chmod +x upgrade.sh
RUN chmod +x entrypoint.sh

# Use the entrypoint script
ENTRYPOINT ["./entrypoint.sh"]
CMD ["python3", "statuspage/manage.py", "runserver", "0.0.0.0:8000", "--insecure"]
