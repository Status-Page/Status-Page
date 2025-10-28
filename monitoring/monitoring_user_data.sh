#!/bin/bash
# Update packages and install Docker + Git
apt update && apt install -y docker.io git

# Enable and start Docker with the system
systemctl enable --now docker

# Install Docker Compose
curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Clone monitoring files from the 'monitoring' branch on GitHub
rm -rf /opt/monitoring
git clone --branch monitoring https://github.com/meitavEini/Status_page_FORKED_REPO.git /opt/monitoring

# Navigate to the folder and run the services
cd /opt/monitoring
docker-compose up -d
