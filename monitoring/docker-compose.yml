version: '3.8'

services:
  prometheus:
    image: prom/prometheus
    container_name: prometheus
    volumes:
      - ./prometheus.yml:/etc/prometheus/prometheus.yml
      - ./recording-rules.yml:/etc/prometheus/recording-rules.yml
    ports:
      - "9090:9090"
    networks:
      - monitoring
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"

  grafana:
    image: grafana/grafana
    container_name: grafana
    depends_on:
      - prometheus
    ports:
      - "3000:3000"
    networks:
      - monitoring
    environment:
      - GF_SECURITY_ADMIN_PASSWORD=admin
      - GF_SECURITY_ADMIN_USER=admin
      - GF_SERVER_ROOT_URL=http://localhost:3000
      - GF_USERS_ALLOW_SIGN_UP=false
      - GF_DASHBOARDS_DEFAULT_HOME_DASHBOARD_PATH=/var/lib/grafana/dashboards/node-monitorinf.json
    volumes:
      - grafana_data:/var/lib/grafana
      - ./datasources.yml:/etc/grafana/provisioning/datasources/datasources.yml
      - ./dashboards.yml:/etc/grafana/provisioning/dashboards/dashboards.yml
      - ./dashboards:/var/lib/grafana/dashboards
    logging:
      driver: "json-file"
      options:
        max-size: "10m"
        max-file: "3"

networks:
  monitoring:
    driver: bridge

volumes:
  grafana_data:
