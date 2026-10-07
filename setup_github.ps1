# ==============================================================================
# SCRIPT OTOMATIS: INTEGRASI KE GITHUB REPOSITORY PRIBADI
# Proyek: OpenSID SaaS & Diskominfo Command Center Banggai Kepulauan
# ==============================================================================

param (
    [string]$RepoUrl = ""
)

Write-Host "======================================================================" -ForegroundColor Cyan
Write-Host "   PENGATURAN GITHUB REPOSITORY - OPENSID SAAS BANGGAI KEPULAUAN" -ForegroundColor Yellow
Write-Host "======================================================================" -ForegroundColor Cyan

# 1. Pastikan URL Repository diberikan
if ([string]::IsNullOrWhiteSpace($RepoUrl)) {
    Write-Host ""
    Write-Host "Silakan masukkan URL repository GitHub Anda yang baru dibuat di github.com." -ForegroundColor Green
    Write-Host "Contoh: https://github.com/username/opensid-saas-bangkep.git" -ForegroundColor DarkGray
    $RepoUrl = Read-Host "Masukkan URL GitHub Repo"
}

if ([string]::IsNullOrWhiteSpace($RepoUrl)) {
    Write-Host "[ERROR] URL Repository tidak boleh kosong!" -ForegroundColor Red
    exit 1
}

# 2. Cek apakah remote 'upstream' sudah ada, jika belum dan 'origin' mengarah ke OpenSID publik, simpan sebagai upstream
$currentOrigin = git remote get-url origin 2>$null
if ($currentOrigin -match "OpenSID/OpenSID") {
    Write-Host "[1/5] Memindahkan remote OpenSID publik ke 'upstream'..." -ForegroundColor Yellow
    git remote rename origin upstream 2>$null
}

# 3. Konfigurasi remote 'origin' ke Repo GitHub Pengguna
$existingOrigin = git remote get-url origin 2>$null
if ($existingOrigin) {
    Write-Host "[2/5] Memperbarui remote 'origin' ke $RepoUrl..." -ForegroundColor Yellow
    git remote set-url origin $RepoUrl
} else {
    Write-Host "[2/5] Menambahkan remote 'origin' ($RepoUrl)..." -ForegroundColor Yellow
    git remote add origin $RepoUrl
}

# 4. Pastikan berada di branch main
Write-Host "[3/5] Mengatur branch utama ke 'main'..." -ForegroundColor Yellow
git branch -M main

# 5. Staging semua file yang belum di-commit
Write-Host "[4/5] Melakukan staging berkas dan commit..." -ForegroundColor Yellow
git add .
$statusOutput = git status --porcelain
if ($statusOutput) {
    git commit -m "feat: integrasi opensid saas banggai kepulauan, diskominfo hub & konfigurasi docker vps"
    Write-Host "      Commit berhasil dibuat!" -ForegroundColor Green
} else {
    Write-Host "      Tidak ada perubahan baru untuk di-commit." -ForegroundColor DarkGray
}

# 6. Push ke GitHub
Write-Host "[5/5] Mendorong kode (git push) ke GitHub ($RepoUrl)..." -ForegroundColor Cyan
Write-Host "Catatan: Jika diminta login, silakan masukkan Personal Access Token (PAT) atau kredensial GitHub Anda." -ForegroundColor DarkYellow

git push -u origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "======================================================================" -ForegroundColor Green
    Write-Host "  SUKSES! Repositori lokal berhasil terhubung dan ter-push ke GitHub!" -ForegroundColor Green
    Write-Host "  Repository URL: $RepoUrl" -ForegroundColor Cyan
    Write-Host "======================================================================" -ForegroundColor Green
} else {
    Write-Host ""
    Write-Host "[PERINGATAN] Gagal push otomatis. Pastikan repository di GitHub sudah dibuat dan Anda memiliki izin akses." -ForegroundColor Red
    Write-Host "Anda juga dapat mencoba perintah manual: git push -u origin main --force" -ForegroundColor Yellow
}
