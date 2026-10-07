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

## 🐙 BAGIAN 4: Otomatisasi Laptop ➔ GitHub ➔ VPS Staging

Repositori GitHub Resmi Anda:  
👉 **`https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep`**

### 1. Inisialisasi Satu Kali di Terminal VPS
Masuk ke terminal VPS (`ssh -p 2222 root@148.230.102.95`):
```bash
cd /var/www/opensid-saas
git remote set-url origin https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep.git
git fetch origin main
git branch -M main
git reset --hard origin/main
chmod +x update_from_github.sh deploy_staging.sh
```

---

### 2. Konfigurasi GitHub Actions Auto-Deploy (Opsional tapi Direkomendasikan)
Agar setiap kali Anda push dari laptop, VPS langsung terupdate otomatis tanpa harus buka terminal VPS:
1. Buka repo Anda: `https://github.com/icalpurwanto1990-gif/opensid-saas-bangkep/settings/secrets/actions`
2. Klik tombol **New repository secret**, lalu tambahkan:
   - **`VPS_PASSWORD`**: Masukkan password root VPS Anda.
   *(Jika VPS memakai SSH Key, masukkan sebagai `VPS_SSH_KEY`)*
3. Selesai! GitHub Actions akan otomatis aktif setiap kali Anda push ke branch `main`.

---

### 3. Alur Kerja Sehari-hari (One-Click Auto-Deploy dari Laptop)
Kapan pun Anda selesai mengedit kode di laptop, buka PowerShell di folder `app_build` dan cukup ketik:
```powershell
.\deploy_now.ps1 "update modul atau fitur baru"
```
Skrip ini akan otomatis:
1. Men-stage dan men-commit semua perubahan terbaru.
2. Melakukan `git push origin main` ke GitHub Anda.
3. Memicu GitHub Actions untuk meng-update kontainer di VPS (`148.230.102.95:8090`).

---

### 4. Alternatif Pembaruan Manual dari Terminal VPS
Jika GitHub Actions belum diatur atau Anda ingin menarik pembaruan langsung dari dalam VPS:
```bash
cd /var/www/opensid-saas
./update_from_github.sh
```
*(Skrip ini otomatis `git pull`, rebuild container jika perlu, dan jalankan `php artisan migrate`)*.

