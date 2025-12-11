#!/bin/sh
set -e

echo "🚀 Starting UMKM Inventory..."

# Create storage directories if they don't exist
mkdir -p /var/www/storage/logs
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/cache
mkdir -p /var/www/bootstrap/cache

# Set permissions
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    echo "⚠️  APP_KEY not set, generating..."
    php artisan key:generate --force
fi

# Clear and cache config
echo "📦 Caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Seed database if empty (optional - only on first deploy)
# Uncomment if you want to seed on first deploy
# php artisan db:seed --force

# Create storage link
php artisan storage:link --force 2>/dev/null || true

echo "✅ Application ready!"
echo "🌐 Starting web server..."

# Start supervisord (manages nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisord.conf
