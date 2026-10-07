#!/bin/bash

# ==============================================================================
# SCRIPT SATU KALI RUN DI TERMINAL VPS
# Menghubungkan direktori VPS /var/www/opensid-saas ke GitHub Anda
# ==============================================================================

set -e

echo "🚀 [1/3] Menghubungkan VPS ke repositori GitHub: icalpurwanto1990-gif/opensid-saas-bangkep..."
cd /var/www/opensid-saas

git remote set-url origin https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep.git 2>/dev/null || \
git remote add origin https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep.git

echo "📥 [2/3] Melakukan sinkronisasi kode awal..."
git fetch origin main
git branch -M main
git reset --hard origin/main

echo "🔑 [3/3] Memberikan izin eksekusi skrip deploy..."
chmod +x update_from_github.sh deploy_staging.sh

echo ""
echo "✅ VPS BERHASIL TERHUBUNG KE GITHUB!"
echo "Sekarang VPS Anda siap menerima pembaruan otomatis dari laptop atau GitHub Actions!"
