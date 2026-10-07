#!/usr/bin/env bash
# Keluar jika ada perintah yang gagal
set -e

# 1. Install dependensi Node & compile Tailwind CSS assets
npm ci
npm run build

# 2. Install dependensi PHP tanpa dev-packages
composer install --no-dev --optimize-autoloader

# 3. Cache konfigurasi Laravel untuk mempercepat performa
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Storage Link & Jalankan Migrasi Database
php artisan storage:link || true
php artisan migrate --force