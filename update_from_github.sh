#!/bin/bash

# ==============================================================================
# SCRIPT UPDATE KODE DI VPS VIA GITHUB (PULL & RELOAD)
# Lokasi di VPS: /var/www/opensid-saas/update_from_github.sh
# ==============================================================================

set -e

echo "🚀 [1/4] Menarik kode pembaruan terbaru dari GitHub (icalpurwanto1990-gif/opensid-saas-bangkep)..."
git fetch origin main
git reset --hard origin/main

echo "🔒 [2/4] Memastikan hak akses folder storage dan desa..."
mkdir -p storage/logs storage/framework/cache storage/framework/views storage/framework/sessions desa/upload desa/config
chmod -R 777 storage desa
chmod +x update_from_github.sh deploy_staging.sh || true

# Pastikan desa/config/database.php dan app_key tersedia
if [ ! -f "desa/config/database.php" ]; then
    cat << 'EOF' > desa/config/database.php
<?php
defined('BASEPATH') || exit('No direct script access allowed');
$db['default']['hostname'] = getenv('DB_HOST') ?: 'db';
$db['default']['username'] = getenv('DB_USERNAME') ?: 'opensid_user';
$db['default']['password'] = getenv('DB_PASSWORD') ?: 'opensid_password';
$db['default']['port']     = (int)(getenv('DB_PORT') ?: 3306);
$db['default']['database'] = getenv('DB_DATABASE') ?: 'opensid_bobu';
$db['default']['dbcollat'] = 'utf8mb4_general_ci';
$db['default']['stricton'] = false;
EOF
fi

if [ ! -f "desa/app_key" ]; then
    echo "base64:rN3vXWFRHDKFP2sMySe9f4gna7WulisoXTqn7Yo4Ye8=" > desa/app_key
fi

echo "🐳 [3/4] Memperbarui dan merestart kontainer Docker Staging..."
docker compose -f docker-compose.staging.yml up -d

echo "📦 [4/4] Menjalankan pembersihan cache & reload..."
docker exec opensid_staging_app php artisan optimize:clear || true
docker restart opensid_staging_app

echo ""
echo "🎉 PEMBARUAN DARI GITHUB BERHASIL DITERAPKAN DI VPS!"
echo "=============================================================================="
docker compose -f docker-compose.staging.yml ps
