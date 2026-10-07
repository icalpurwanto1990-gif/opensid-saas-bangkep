# ==============================================================================
# SCRIPT RUNNER DOCKER LAPTOP (WINDOWS POWERSHELL)
# ==============================================================================

Write-Host "[1/3] Menyiapkan environment Docker..." -ForegroundColor Cyan
Remove-Item Env:\DOCKER_API_VERSION -ErrorAction SilentlyContinue

Write-Host "[2/3] Membersihkan kontainer lama..." -ForegroundColor Yellow
docker compose down 2>$null

Write-Host "[3/3] Membangun dan Menjalankan Kontainer OpenSID SaaS di Port 8090..." -ForegroundColor Cyan
docker compose up -d --build

Write-Host ""
Write-Host "==============================================================================" -ForegroundColor DarkGray
Write-Host "Command Center Diskominfo : http://localhost:8090/index.php/diskominfo" -ForegroundColor White
Write-Host "Monitoring Desa SaaS      : http://localhost:8090/index.php/diskominfo/desa" -ForegroundColor White
Write-Host "WebGIS Banggai Kepulauan  : http://localhost:8090/index.php/diskominfo/gis" -ForegroundColor White
Write-Host "Portal Pilot Desa Bobu    : http://localhost:8090/index.php?desa=bobu" -ForegroundColor White
Write-Host "Database phpMyAdmin       : http://localhost:8091" -ForegroundColor Yellow
Write-Host "==============================================================================" -ForegroundColor DarkGray
