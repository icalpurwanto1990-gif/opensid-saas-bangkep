# ==============================================================================
# SCRIPT SATU PINTU: OTOMATIS COMMIT, PUSH KE GITHUB & TRIGGER DEPLOY VPS
# Proyek: OpenSID SaaS & Diskominfo Command Center Banggai Kepulauan
# ==============================================================================

param (
    [string]$Message = ""
)

Write-Host "======================================================================" -ForegroundColor Cyan
Write-Host "       🚀 AUTO-DEPLOY PIPELINE: LAPTOP ➔ GITHUB ➔ VPS STAGING          " -ForegroundColor Yellow
Write-Host "======================================================================" -ForegroundColor Cyan

# 1. Pastikan ada pesan commit
if ([string]::IsNullOrWhiteSpace($Message)) {
    Write-Host ""
    $Message = ReadHostWithMessage
}

function ReadHostWithMessage {
    $inputMsg = Read-Host "Masukkan catatan pembaruan (contoh: update modul diskominfo)"
    if ([string]::IsNullOrWhiteSpace($inputMsg)) {
        return "chore: pembaruan kode rutin $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
    }
    return $inputMsg
}

if ([string]::IsNullOrWhiteSpace($Message)) {
    $Message = "chore: pembaruan kode rutin $(Get-Date -Format 'yyyy-MM-dd HH:mm')"
}

# 2. Stage semua berkas
Write-Host ""
Write-Host "[1/3] Menyiapkan berkas perubahan (git add)..." -ForegroundColor Yellow
git add .

# 3. Commit berkas
$changes = git status --porcelain
if ($changes) {
    Write-Host "[2/3] Menyimpan perubahan ke Git Commit: '$Message'..." -ForegroundColor Yellow
    git commit -m "$Message"
} else {
    Write-Host "[2/3] Tidak ada file baru yang diubah. Memastikan sinkronisasi..." -ForegroundColor DarkGray
}

# 4. Push ke GitHub
Write-Host "[3/3] Mengirimkan perubahan (git push) ke GitHub..." -ForegroundColor Cyan
git push origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "======================================================================" -ForegroundColor Green
    Write-Host "  ✅ BERHASIL! Kode terbaru telah terunggah ke GitHub!" -ForegroundColor Green
    Write-Host "  GitHub Repo : https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep" -ForegroundColor Cyan
    Write-Host "  Status CI/CD: https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep/actions" -ForegroundColor Yellow
    Write-Host "======================================================================" -ForegroundColor Green
    Write-Host "💡 GitHub Actions sedang memproses pengiriman otomatis ke server VPS Anda." -ForegroundColor White
    Write-Host "   Dalam 30-60 detik, aplikasi di VPS langsung terupdate di:" -ForegroundColor White
    Write-Host "   🌐 http://148.230.102.95:8090/index.php/diskominfo" -ForegroundColor Green
    Write-Host "======================================================================" -ForegroundColor Green
} else {
    Write-Host ""
    Write-Host "❌ Gagal melakukan push ke GitHub. Silakan periksa koneksi internet atau hak akses Anda." -ForegroundColor Red
}
