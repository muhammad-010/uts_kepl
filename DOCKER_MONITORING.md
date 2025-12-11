# Docker Monitoring Guide

## 🚀 Quick Start

```bash
# Start all services
docker-compose up -d

# Wait for services to initialize (30-60 seconds)
sleep 60

# Check all containers are running
docker-compose ps
```

## 📊 Access Dashboard

| Service | URL | Credentials |
|---------|-----|-------------|
| **Grafana Dashboard** | http://localhost:3000 | admin / admin |
| **Prometheus** | http://localhost:9091 | - |
| **cAdvisor** | http://localhost:8081 | - |
| **Application** | http://localhost:8080 | - |
| **Node Exporter** | http://localhost:9100/metrics | - |

## 📈 Available Metrics

The pre-configured Grafana dashboard includes:

### Container Metrics (via cAdvisor)
| Metric | Description |
|--------|-------------|
| 🖥️ CPU Usage | CPU usage percentage per container |
| 💾 Memory Usage | Memory consumption in bytes per container |
| 🌐 Network I/O | Network bytes received/transmitted per container |
| 💿 Disk I/O | Filesystem read/write bytes per container |

### Host Metrics (via Node Exporter)
| Metric | Description |
|--------|-------------|
| 🖥️ Host CPU Usage | Overall CPU usage of the host machine |
| 💾 Host Memory Usage | Overall memory usage of the host machine |
| 💿 Host Disk Usage | Root filesystem usage of the host machine |
| 📦 Running Containers | Count of currently running containers |

## 🔧 Useful Commands

```bash
# View logs
docker-compose logs -f grafana
docker-compose logs -f prometheus

# Restart a single service
docker-compose restart grafana

# Stop all services
docker-compose down

# Stop and remove volumes (WARNING: deletes data)
docker-compose down -v

# Rebuild app container
docker-compose build app
docker-compose up -d app
```

## 🛠️ Troubleshooting

### Grafana shows "No data"
1. Wait 1-2 minutes for metrics to populate
2. Check Prometheus targets: http://localhost:9091/targets
3. All targets should show "UP" status

### cAdvisor not working on macOS
cAdvisor has limited support on macOS Docker Desktop. Some metrics may not be available.

### Permission denied on volumes
```bash
# Fix permissions for Docker volumes
sudo chown -R $(id -u):$(id -g) ./grafana
```

## 📁 File Structure

```
├── docker-compose.yml          # Main Docker Compose config
├── prometheus/
│   └── prometheus.yml          # Prometheus scrape config
├── grafana/
│   ├── dashboards/
│   │   └── cadvisor.json       # Pre-built dashboard
│   └── provisioning/
│       ├── dashboards/
│       │   └── dashboard.yml   # Dashboard provisioning
│       └── datasources/
│           └── datasource.yml  # Prometheus datasource
└── nginx.conf                  # Nginx config for Laravel app
```
