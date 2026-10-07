# ==============================================================================
# SCRIPT SINKRONISASI KODE DARI LAPTOP KE SERVER VPS STAGING
# Mengirimkan perubahan terbaru ke /var/www/opensid-saas
# Port SSH VPS: 2222 | IP VPS: 148.230.102.95
# ==============================================================================

param (
    [string]$VpsIp = "148.230.102.95",
    [int]$SshPort = 2222,
    [string]$VpsUser = "root",
    [string]$VpsPath = "/var/www/opensid-saas"
)

Write-Host "[1/3] Memulai sinkronisasi kode dari Laptop ke VPS (${VpsIp}:${SshPort})..." -ForegroundColor Cyan

# Pastikan berada di folder app_build
$currentDir = (Get-Location).Path
Write-Host "Folder asal: $currentDir" -ForegroundColor DarkGray

# 1. Sync Modules (Diskominfo Command Center, SaaS Tenancy)
Write-Host "[2/3] Mengunggah folder Modules dan Controller..." -ForegroundColor Yellow
scp -P $SshPort -r Modules "${VpsUser}@${VpsIp}:${VpsPath}/"
scp -P $SshPort -r donjo-app/controllers/Diskominfo.php "${VpsUser}@${VpsIp}:${VpsPath}/donjo-app/controllers/"
scp -P $SshPort -r donjo-app/Routes/Web/diskominfo.php "${VpsUser}@${VpsIp}:${VpsPath}/donjo-app/Routes/Web/"
scp -P $SshPort -r app/Services/Tenancy "${VpsUser}@${VpsIp}:${VpsPath}/app/Services/"
scp -P $SshPort -r docker/nginx/default.conf "${VpsUser}@${VpsIp}:${VpsPath}/docker/nginx/"

Write-Host "[3/3] Sinkronisasi Selesai!" -ForegroundColor Green
Write-Host "Perubahan kode Anda sudah langsung aktif di server VPS tanpa perlu restart!" -ForegroundColor Cyan
