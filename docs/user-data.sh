#!/bin/bash

# Update system and install basic packages
sudo apt update && sudo apt install -y git docker.io docker-compose # apt update && apt install -y git docker.io docker-compose

# Add ubuntu user to docker group
sudo usermod -aG docker ubuntu # sudo usermod -aG sudo ubuntu

newgrp docker # newgrp sudo

# Clone your repository
mkdir -p /opt/status-page # sudo mkdir -p /opt/status-page
cd /opt/status-page
git clone https://github.com/meitavEini/Status_page_FORKED_REPO.git .
git checkout main

sleep 10

# Run the app
sudo docker-compose -f docker-compose.yml up -d --build

# Install node_exporter
useradd -rs /bin/false node_exporter
wget https://github.com/prometheus/node_exporter/releases/download/v1.6.1/node_exporter-1.6.1.linux-amd64.tar.gz
tar xvfz node_exporter-1.6.1.linux-amd64.tar.gz
cp node_exporter-1.6.1.linux-amd64/node_exporter /usr/local/bin/
cat <<EOF > /etc/systemd/system/node_exporter.service
[Unit]
Description=Node Exporter
After=network.target

[Service]
User=node_exporter
ExecStart=/usr/local/bin/node_exporter

[Install]
WantedBy=default.target
EOF

systemctl daemon-reexec
systemctl daemon-reload
systemctl enable node_exporter
systemctl start node_exporter