# 📘 Panduan Lengkap: Menjalankan di Docker Laptop & Deploy ke Server VPS Staging

**Aplikasi**: OpenSID SaaS Multi-Tenant & Diskominfo Command Center  
**Wilayah**: Kabupaten Banggai Kepulauan (Pilot: Desa Bobu, Kec. Tinangkung Selatan)  
**Port Bebas Bentrok**: Web App `8090` • phpMyAdmin `8091` • MariaDB `3308`  

---

## 💻 BAGIAN 1: Menjalankan di Docker Laptop (Pengujian Langsung)

### Langkah-langkah:
1. Buka aplikasi **Docker Desktop** di laptop Anda dan pastikan statusnya sudah *Running*.
2. Buka terminal (PowerShell / Command Prompt) dan arahkan ke folder `app_build`:
   ```bash
   cd "d:\PROYEK LARAVEL\Project Desa\app_build"
   ```
3. Jika sebelumnya kontainer sempat dibuat separuh jalan, bersihkan dulu kontainer lama:
   ```bash
   docker compose down
   ```
4. Jalankan Docker Compose dengan port baru dan build cepat (`.dockerignore` aktif):
   ```bash
   docker compose up -d --build
   ```
5. Buka browser Anda dan akses port **8090**:
   - **Command Center Diskominfo**: [http://localhost:8090/index.php/diskominfo](http://localhost:8090/index.php/diskominfo)
   - **Manajemen Desa SaaS**: [http://localhost:8090/index.php/diskominfo/desa](http://localhost:8090/index.php/diskominfo/desa)
   - **WebGIS Spasial Bangkep**: [http://localhost:8090/index.php/diskominfo/gis](http://localhost:8090/index.php/diskominfo/gis)
   - **Portal Desa Bobu**: [http://localhost:8090/index.php?desa=bobu](http://localhost:8090/index.php?desa=bobu)
   - **phpMyAdmin (Kelola DB)**: [http://localhost:8091](http://localhost:8091) *(User: `root`, Password: `opensid_root_secret`)*

---

## ☁️ BAGIAN 2: Deploy Langsung ke Server VPS Staging

### Langkah 1: Hubungkan ke Server VPS (SSH)
```bash
ssh root@<IP_VPS_ANDA>
```

Pastikan Docker terpasang di VPS:
```bash
curl -fsSL https://get.docker.com | sh
```

### Langkah 2: Transfer Kode ke VPS
Transfer folder `app_build` dari laptop ke VPS:
```bash
# Dijalankan dari terminal laptop Anda:
scp -r "d:\PROYEK LARAVEL\Project Desa\app_build" root@<IP_VPS_ANDA>:/var/www/opensid-saas
```

### Langkah 3: Eksekusi Deploy Staging di VPS
Di dalam terminal VPS:
```bash
cd /var/www/opensid-saas
chmod +x deploy_staging.sh
bash deploy_staging.sh
```

### Langkah 4: Akses Aplikasi di Server VPS Staging
Setelah proses selesai, aplikasi langsung aktif di port **8090**:
- **Diskominfo Command Center**: `http://<IP_VPS_ANDA>:8090/index.php/diskominfo`
- **Monitoring Desa Terintegrasi**: `http://<IP_VPS_ANDA>:8090/index.php/diskominfo/desa`
- **Peta WebGIS Banggai Kepulauan**: `http://<IP_VPS_ANDA>:8090/index.php/diskominfo/gis`
- **Portal Percontohan Desa Bobu**: `http://<IP_VPS_ANDA>:8090/index.php?desa=bobu`

---

## 🗄️ BAGIAN 3: Panduan Lengkap Koneksi & Pengelolaan Database di VPS

### 1. Bagaimana Database Disediakan di VPS? (Otomatis / Zero-Setup)
Saat Anda menjalankan `bash deploy_staging.sh`, Docker Compose **secara otomatis membuatkan kontainer database MariaDB 10.6** (`opensid_staging_db`) di dalam server VPS.
Anda **tidak perlu repot menginstall MySQL/MariaDB secara manual di VPS**.

Kredensial bawaan yang dibuat otomatis:
* **Host Database**: `staging_db` *(komunikasi internal antar kontainer)*
* **Nama Database**: `opensid_bobu`
* **Username**: `opensid_user`
* **Password**: `opensid_password`
* **Password Root**: `opensid_root_secret`
* **Penyimpanan Permanen**: Data tersimpan di Docker Volume `opensid_staging_db_data:/var/lib/mysql` (data **tidak akan hilang** meskipun kontainer direstart/update).

---

### 2. Cara Inisialisasi Tabel / Skema Awal di VPS
Setelah kontainer menyala di VPS, ada 2 cara untuk mengisi struktur tabel:

#### Cara A: Melalui Perintah Artisan (1 Baris di VPS)
Di terminal VPS Anda, jalankan perintah ini untuk mengeksekusi 438 migrasi struktur tabel:
```bash
docker exec -it opensid_staging_app php artisan migrate
```
*(Atau jalankan `docker exec -it opensid_staging_app php artisan opensid:setup`)*.

#### Cara B: Melalui Web Installer Wizard
Buka browser Anda dan akses:
```text
http://<IP_VPS_ANDA>:8090/install
```
Ikuti petunjuk konfigurasi di layar untuk inisialisasi basis data interaktif.

---

### 3. Jika Ingin Menggunakan MySQL Bawaan VPS (Non-Docker)
Jika di server VPS Anda sudah terpasang MySQL/MariaDB native di luar Docker dan ingin menggunakannya:
1. Masuk ke MySQL di VPS:
   ```bash
   mysql -u root -p
   ```
2. Buat database dan user:
   ```sql
   CREATE DATABASE opensid_bobu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'opensid_user'@'%' IDENTIFIED BY 'opensid_password';
   GRANT ALL PRIVILEGES ON opensid_bobu.* TO 'opensid_user'@'%';
   FLUSH PRIVILEGES;
   EXIT;
   ```
3. Ubah file `.env` di folder project VPS:
   ```env
   DB_HOST=172.17.0.1    # IP default gateway host Docker
   DB_DATABASE=opensid_bobu
   DB_USERNAME=opensid_user
   DB_PASSWORD=opensid_password
   ```

---

### 4. Cara Backup & Restore Database di VPS
* **Backup (Dump Database ke file .sql)**:
  ```bash
  docker exec opensid_staging_db mysqldump -u root -popensid_root_secret opensid_bobu > /var/www/backup_bobu.sql
  ```
* **Restore (Import file .sql ke Database)**:
  ```bash
  cat /var/www/backup_bobu.sql | docker exec -i opensid_staging_db mysql -u root -popensid_root_secret opensid_bobu
  ```

---

## 🐙 BAGIAN 4: Integrasi GitHub & Sinkronisasi Kode ke VPS

### 1. Hubungkan Proyek Lokal ke GitHub Pribadi Anda
Di terminal laptop Anda (folder `app_build`):
```powershell
# Jalankan skrip pembantu otomatis:
.\setup_github.ps1 -RepoUrl "https://github.com/USERNAME/NAMA-REPO.git"
```
Atau manual:
```powershell
git remote rename origin upstream     # Simpan OpenSID publik sebagai upstream
git remote add origin https://github.com/USERNAME/NAMA-REPO.git
git branch -M main
git add .
git commit -m "feat: inisialisasi opensid saas banggai kepulauan & diskominfo"
git push -u origin main
```

### 2. Menghubungkan VPS ke GitHub Anda
Di terminal VPS (`ssh -p 2222 root@148.230.102.95`):
```bash
cd /var/www/opensid-saas
git remote set-url origin https://github.com/USERNAME/NAMA-REPO.git
```

### 3. Cara Mengupdate VPS Cukup 1 Baris:
Kapan pun Anda selesai mengedit kode di laptop dan melakukan `git push`:
Di terminal VPS cukup jalankan:
```bash
./update_from_github.sh
```
Skrip ini akan otomatis melakukan `git pull`, build ulang kontainer Docker jika ada perubahan konfigurasi, dan menjalankan migrasi database otomatis!

