# UMKM Inventory Management System (Laravel 11)

Backend RESTful API + simple Blade UI (Bootstrap + Axios). Auth via Laravel Sanctum.

## Requirements
- Docker & Docker Compose (recommended), or
- PHP 8.2, Composer, MySQL 8

## Setup (Docker)
```bash
git clone <repo-url> && cd UMKM-Inventory
cp .env.example .env
# Start containers
docker compose up -d --build
# Run migrations & seeds inside app container
docker exec -it umkm_app php artisan migrate --force
docker exec -it umkm_app php artisan db:seed --force
Open http://localhost:8080 - Login: admin@umkm.test / password123
Sanctum
Package is required in composer.json. If needed, publish config/migrations:
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
API Endpoints
•	POST /api/login → { email, password }
•	GET /api/profile (auth)
•	POST /api/logout (auth)
•	apiResource /api/customers (auth)
•	apiResource /api/products (auth)
Testing
composer test
GitLab CI/CD
•	Branches: main, dev
•	Invite: galihgitlab@gmail.com
•	Pipelines: install → test → deploy (simulated)
Notes
•	Default users seeded with roles admin and user.
•	Frontend uses Axios for JSON exchange. ```