#!/bin/bash

# Railway deployment script
echo "🚀 Railway Deployment Starting..."

# Install PHP dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Clear and cache config
echo "⚙️ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed database if empty
echo "🌱 Seeding database..."
php artisan db:seed --force

echo "✅ Deployment complete!"
