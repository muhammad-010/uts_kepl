#!/usr/bin/env bash
set -e

# pastikan APP_KEY ada, kalau belum generate
php -r "exit((getenv('APP_KEY') && getenv('APP_KEY')!='') ? 0 : 1);" || php artisan key:generate --force

echo "[start] waiting DB & migrate..."
RETRIES=20
until php artisan migrate --force; do
  ((RETRIES--)); [ $RETRIES -le 0 ] && echo "migrate failed" && exit 1
  echo "DB not ready, retry in 3s ($RETRIES left)"; sleep 3
done

php artisan migrate --force || (php artisan cache:table && php artisan migrate --force)
php artisan db:seed --force || true
php artisan storage:link || true

echo "[start] starting server on port ${PORT:-8080}"
exec php artisan serve --host 0.0.0.0 --port ${PORT:-8080}