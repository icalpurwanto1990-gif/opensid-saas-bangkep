#!/bin/bash

# ==============================================================================
# SCRIPT UPDATE KODE DI VPS VIA GITHUB (PULL & RELOAD)
# Lokasi di VPS: /var/www/opensid-saas/update_from_github.sh
# ==============================================================================

set -e

echo "🚀 [1/4] Menarik kode pembaruan terbaru dari GitHub..."
git pull origin main

echo "🔒 [2/4] Memastikan hak akses folder storage dan desa..."
mkdir -p storage desa/upload desa/config
chmod -R 775 storage desa

echo "🐳 [3/4] Memperbarui dan merestart kontainer Docker jika ada perubahan..."
docker compose -f docker-compose.staging.yml up -d --build

echo "📦 [4/4] Menjalankan migrasi database otomatis..."
docker exec -t opensid_staging_app php artisan migrate --force || true
docker exec -t opensid_staging_app php artisan optimize:clear || true

echo ""
echo "🎉 PEMBARUAN DARI GITHUB BERHASIL DITERAPKAN DI VPS!"
echo "=============================================================================="
docker compose -f docker-compose.staging.yml ps
