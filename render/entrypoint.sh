#!/bin/sh
set -e

echo "==> Menyiapkan direktori storage & cache..."
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "==> Menjalankan migrasi database..."
php artisan migrate --force || true

echo "==> Menjalankan seeder (jika database masih kosong)..."
php artisan db:seed --force || true

echo "==> Menjalankan PHP-FPM..."
php-fpm -D

echo "==> Menjalankan Nginx..."
exec nginx -g "daemon off;"
