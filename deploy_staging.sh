#!/bin/bash

# ==============================================================================
# SCRIPT DEPLOYMENT OTOMATIS OPENSID SAAS DISKOMINFO KE SERVER VPS STAGING
# Kabupaten Banggai Kepulauan (Pilot: Desa Bobu) - Port 8090
# IP VPS: 148.230.102.95
# ==============================================================================

set -e

echo "🚀 [1/6] Memulai proses deployment staging (Port 8090)..."

# Cek apakah docker terinstall
if ! command -v docker &> /dev/null; then
    echo "❌ Error: Docker belum terinstall di server VPS ini."
    echo "💡 Menginstall Docker otomatis..."
    curl -fsSL https://get.docker.com | sh
fi

# Cek file konfigurasi env
if [ ! -f .env ]; then
    echo "📄 [2/6] Membuat file .env dari .env.docker..."
    cp .env.docker .env
fi

# Pastikan folder penting memiliki permission yang benar
echo "🔒 [3/6] Mengatur hak akses folder storage dan desa..."
mkdir -p storage desa/upload desa/config
chmod -R 775 storage desa

# Buka firewall UFW jika UFW aktif di VPS
if command -v ufw &> /dev/null; then
    echo "🛡️ [4/6] Membuka port 8090 di firewall VPS (UFW)..."
    ufw allow 8090/tcp || true
    ufw reload || true
fi

# Build dan jalankan container staging
echo "🐳 [5/6] Membangun dan menjalankan kontainer Docker Staging di Port 8090..."
docker compose -f docker-compose.staging.yml up -d --build

# Tunggu database siap
echo "⏳ Menunggu database MariaDB siap menerima koneksi..."
sleep 10

# Jalankan migrasi basis data secara otomatis jika belum ada tabel
echo "📦 [6/6] Menjalankan migrasi skema database OpenSID & Pilot Desa Bobu..."
docker exec -t opensid_staging_app php artisan migrate --force || true

echo ""
echo "🎉 DEPLOYMENT STAGING BERHASIL!"
echo "=============================================================================="
echo "🌐 Command Center Diskominfo : http://148.230.102.95:8090/index.php/diskominfo"
echo "🌐 Monitoring Desa SaaS      : http://148.230.102.95:8090/index.php/diskominfo/desa"
echo "🌐 WebGIS Banggai Kepulauan  : http://148.230.102.95:8090/index.php/diskominfo/gis"
echo "🌐 Portal Pilot Desa Bobu    : http://148.230.102.95:8090/index.php?desa=bobu"
echo "=============================================================================="
echo "📋 Status Kontainer Aktif:"
docker compose -f docker-compose.staging.yml ps
