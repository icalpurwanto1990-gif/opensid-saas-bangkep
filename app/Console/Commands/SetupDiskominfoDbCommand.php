<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use Throwable;

class SetupDiskominfoDbCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'diskominfo:setup-db {--admin-user=admin_diskominfo} {--admin-pass=Bangkep@2026!}';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Inisialisasi basis data mandiri opensid_diskominfo terpisah dari desa (tabel master, akun admin, dan simpul desa)';

    /**
     * Eksekusi inisialisasi database Diskominfo.
     */
    public function handle(): int
    {
        $this->info('========================================================================');
        $this->info('  INISIALISASI BASIS DATA MANDIRI DISKOMINFO COMMAND CENTER BANGKEP    ');
        $this->info('========================================================================');

        $host   = getenv('DB_HOST') ?: 'db';
        $port   = (int) (getenv('DB_PORT') ?: 3306);
        $dbUser = getenv('DB_USERNAME') ?: 'opensid_user';
        $dbPass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';
        $targetDb = 'opensid_diskominfo';

        try {
            $this->info("🔌 Menghubungkan ke server MariaDB ({$host}:{$port})...");
            $pdo = new PDO("mysql:host={$host};port={$port}", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // 1. Buat database opensid_diskominfo
            $this->info("📦 Membuat basis data fisik '{$targetDb}' jika belum ada...");
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$targetDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$targetDb}`");
            $this->info("   ✓ Basis data '{$targetDb}' siap.");

            // 2. Buat tabel diskominfo_users
            $this->info("👤 Membentuk skema tabel 'diskominfo_users'...");
            $pdo->exec("CREATE TABLE IF NOT EXISTS `diskominfo_users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(50) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `nama_lengkap` VARCHAR(150) NOT NULL,
                `nip` VARCHAR(50) NULL,
                `jabatan` VARCHAR(100) NULL,
                `email` VARCHAR(100) NULL,
                `no_hp` VARCHAR(30) NULL,
                `role` VARCHAR(30) NOT NULL DEFAULT 'superadmin',
                `status` VARCHAR(20) NOT NULL DEFAULT 'aktif',
                `last_login` DATETIME NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $this->info("   ✓ Tabel 'diskominfo_users' siap.");

            // 3. Buat tabel diskominfo_tenants
            $this->info("🌐 Membentuk skema tabel 'diskominfo_tenants'...");
            $pdo->exec("CREATE TABLE IF NOT EXISTS `diskominfo_tenants` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `nama_desa` VARCHAR(100) NOT NULL,
                `slug` VARCHAR(50) NOT NULL UNIQUE,
                `kecamatan` VARCHAR(100) NOT NULL,
                `kode_desa` VARCHAR(30) NULL,
                `tipe_server` VARCHAR(30) NOT NULL DEFAULT 'internal_saas',
                `vendor_name` VARCHAR(150) NULL,
                `vendor_contact` VARCHAR(150) NULL,
                `url_portal` VARCHAR(255) NULL,
                `sla_target` DECIMAL(5,2) DEFAULT 99.00,
                `uptime_pct` DECIMAL(5,2) DEFAULT 99.50,
                `latency_ms` INT DEFAULT 0,
                `last_status` VARCHAR(20) DEFAULT 'online',
                `last_ping_at` DATETIME NULL,
                `api_token` VARCHAR(100) NULL,
                `total_penduduk` INT DEFAULT 0,
                `total_kk` INT DEFAULT 0,
                `total_surat` INT DEFAULT 0,
                `apbdes_total` BIGINT DEFAULT 0,
                `apbdes_realisasi` BIGINT DEFAULT 0,
                `bansos_tersalurkan` INT DEFAULT 0,
                `db_name` VARCHAR(100) NULL,
                `lat` DECIMAL(10,7) NULL,
                `lng` DECIMAL(10,7) NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $this->info("   ✓ Tabel 'diskominfo_tenants' siap.");

            // 4. Buat tabel diskominfo_sla_pings
            $this->info("📡 Membentuk skema tabel 'diskominfo_sla_pings'...");
            $pdo->exec("CREATE TABLE IF NOT EXISTS `diskominfo_sla_pings` (
                `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
                `tenant_slug` VARCHAR(50) NOT NULL,
                `url_target` VARCHAR(255) NULL,
                `http_code` INT NOT NULL DEFAULT 200,
                `latency_ms` INT NOT NULL DEFAULT 0,
                `status` VARCHAR(20) NOT NULL DEFAULT 'online',
                `message` TEXT NULL,
                `checked_at` DATETIME NOT NULL,
                INDEX idx_slug (tenant_slug),
                INDEX idx_checked (checked_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $this->info("   ✓ Tabel 'diskominfo_sla_pings' siap.");

            // 5. Buat tabel diskominfo_sla_incidents
            $this->info("⚠️ Membentuk skema tabel 'diskominfo_sla_incidents'...");
            $pdo->exec("CREATE TABLE IF NOT EXISTS `diskominfo_sla_incidents` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `tenant_slug` VARCHAR(50) NOT NULL,
                `vendor_name` VARCHAR(150) NULL,
                `incident_title` VARCHAR(200) NOT NULL,
                `root_cause` TEXT NULL,
                `start_time` DATETIME NOT NULL,
                `end_time` DATETIME NULL,
                `duration_minutes` INT DEFAULT 0,
                `status` VARCHAR(30) DEFAULT 'RESOLVED',
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            $this->info("   ✓ Tabel 'diskominfo_sla_incidents' siap.");

            // 6. Seed Super Admin Diskominfo
            $adminUser = $this->option('admin-user') ?: 'admin_diskominfo';
            $adminPass = $this->option('admin-pass') ?: 'Bangkep@2026!';
            $hashedPass = password_hash($adminPass, PASSWORD_BCRYPT);

            $stmtCheck = $pdo->prepare("SELECT id FROM diskominfo_users WHERE username = ?");
            $stmtCheck->execute([$adminUser]);
            if (! $stmtCheck->fetch()) {
                $stmtInsert = $pdo->prepare("INSERT INTO diskominfo_users (username, password, nama_lengkap, nip, jabatan, email, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmtInsert->execute([
                    $adminUser,
                    $hashedPass,
                    'Administrator Diskominfo Bangkep',
                    '198508202010011012',
                    'Pranata Komputer Ahli Muda / Pengelola SPBE',
                    'admin.diskominfo@banggaikep.go.id',
                    'superadmin',
                    'aktif',
                ]);
                $this->info("🔑 Super Admin '{$adminUser}' berhasil dibuat di basis data '{$targetDb}'.");
            } else {
                $this->line("ℹ️ Super Admin '{$adminUser}' sudah ada.");
            }

            // 7. Seed Data Awal Simpul Desa Multi-Vendor
            $tenantsData = [
                [
                    'nama_desa'       => 'Desa Bobu',
                    'slug'            => 'bobu',
                    'kecamatan'       => 'Tinangkung Selatan',
                    'kode_desa'       => '72.07.03.2001',
                    'tipe_server'     => 'internal_saas',
                    'vendor_name'     => 'Diskominfo Banggai Kepulauan (Cloud)',
                    'vendor_contact'  => 'diskominfo@banggaikep.go.id / 0821-9988-7766',
                    'url_portal'      => 'http://148.230.102.95:8090/index.php?desa=bobu',
                    'sla_target'      => 99.50,
                    'uptime_pct'      => 99.92,
                    'latency_ms'      => 45,
                    'last_status'     => 'online',
                    'api_token'       => 'token_bobu_bangkep_2026',
                    'total_penduduk'  => 1428,
                    'total_kk'        => 386,
                    'total_surat'     => 142,
                    'apbdes_total'    => 1250000000,
                    'apbdes_realisasi'=> 980000000,
                    'bansos_tersalurkan' => 292,
                    'db_name'         => 'opensid_bobu',
                    'lat'             => -1.385200,
                    'lng'             => 123.321400,
                ],
                [
                    'nama_desa'       => 'Desa Mansamat',
                    'slug'            => 'mansamat',
                    'kecamatan'       => 'Tinangkung Selatan',
                    'kode_desa'       => '72.07.03.2002',
                    'tipe_server'     => 'internal_saas',
                    'vendor_name'     => 'Diskominfo Banggai Kepulauan (Cloud)',
                    'vendor_contact'  => 'diskominfo@banggaikep.go.id',
                    'url_portal'      => 'http://148.230.102.95:8090/index.php?desa=mansamat',
                    'sla_target'      => 99.50,
                    'uptime_pct'      => 99.80,
                    'latency_ms'      => 52,
                    'last_status'     => 'online',
                    'api_token'       => 'token_mansamat_bangkep_2026',
                    'total_penduduk'  => 1150,
                    'total_kk'        => 312,
                    'total_surat'     => 98,
                    'apbdes_total'    => 1120000000,
                    'apbdes_realisasi'=> 870000000,
                    'bansos_tersalurkan' => 210,
                    'db_name'         => 'opensid_mansamat',
                    'lat'             => -1.391000,
                    'lng'             => 123.335000,
                ],
                [
                    'nama_desa'       => 'Desa Patukuki',
                    'slug'            => 'patukuki',
                    'kecamatan'       => 'Peling Tengah',
                    'kode_desa'       => '72.07.08.2005',
                    'tipe_server'     => 'external_hosting',
                    'vendor_name'     => 'PT Media Desa Digital',
                    'vendor_contact'  => 'support@mediadesa.co.id / 0812-3344-5566',
                    'url_portal'      => 'https://patukuki.desa.id',
                    'sla_target'      => 99.00,
                    'uptime_pct'      => 99.45,
                    'latency_ms'      => 120,
                    'last_status'     => 'online',
                    'api_token'       => 'token_patukuki_mdd_2026',
                    'total_penduduk'  => 980,
                    'total_kk'        => 274,
                    'total_surat'     => 64,
                    'apbdes_total'    => 980000000,
                    'apbdes_realisasi'=> 740000000,
                    'bansos_tersalurkan' => 180,
                    'db_name'         => null,
                    'lat'             => -1.412000,
                    'lng'             => 123.245000,
                ],
                [
                    'nama_desa'       => 'Desa Buko',
                    'slug'            => 'buko',
                    'kecamatan'       => 'Buko',
                    'kode_desa'       => '72.07.01.2001',
                    'tipe_server'     => 'external_vps',
                    'vendor_name'     => 'CV Celebes Cloud Mandiri',
                    'vendor_contact'  => 'noc@celebescloud.net / 0852-1122-3344',
                    'url_portal'      => 'https://buko.desa.id',
                    'sla_target'      => 99.00,
                    'uptime_pct'      => 98.85,
                    'latency_ms'      => 195,
                    'last_status'     => 'online',
                    'api_token'       => 'token_buko_ccm_2026',
                    'total_penduduk'  => 1620,
                    'total_kk'        => 425,
                    'total_surat'     => 115,
                    'apbdes_total'    => 1380000000,
                    'apbdes_realisasi'=> 1050000000,
                    'bansos_tersalurkan' => 310,
                    'db_name'         => null,
                    'lat'             => -1.355000,
                    'lng'             => 123.155000,
                ],
                [
                    'nama_desa'       => 'Desa Bulagi',
                    'slug'            => 'bulagi',
                    'kecamatan'       => 'Bulagi',
                    'kode_desa'       => '72.07.05.2001',
                    'tipe_server'     => 'custom_cms',
                    'vendor_name'     => 'Inisiatif Swadaya Desa',
                    'vendor_contact'  => 'kades@bulagi.desa.id',
                    'url_portal'      => 'https://bulagi.desa.id',
                    'sla_target'      => 98.50,
                    'uptime_pct'      => 99.10,
                    'latency_ms'      => 145,
                    'last_status'     => 'online',
                    'api_token'       => 'token_bulagi_custom_2026',
                    'total_penduduk'  => 2100,
                    'total_kk'        => 560,
                    'total_surat'     => 180,
                    'apbdes_total'    => 1600000000,
                    'apbdes_realisasi'=> 1200000000,
                    'bansos_tersalurkan' => 450,
                    'db_name'         => null,
                    'lat'             => -1.450000,
                    'lng'             => 123.210000,
                ],
                [
                    'nama_desa'       => 'Desa Tataba',
                    'slug'            => 'tataba',
                    'kecamatan'       => 'Buko',
                    'kode_desa'       => '72.07.01.2002',
                    'tipe_server'     => 'internal_saas',
                    'vendor_name'     => 'Diskominfo Banggai Kepulauan (Cloud)',
                    'vendor_contact'  => 'diskominfo@banggaikep.go.id',
                    'url_portal'      => 'http://148.230.102.95:8090/index.php?desa=tataba',
                    'sla_target'      => 99.50,
                    'uptime_pct'      => 99.88,
                    'latency_ms'      => 48,
                    'last_status'     => 'online',
                    'api_token'       => 'token_tataba_bangkep_2026',
                    'total_penduduk'  => 890,
                    'total_kk'        => 230,
                    'total_surat'     => 52,
                    'apbdes_total'    => 890000000,
                    'apbdes_realisasi'=> 680000000,
                    'bansos_tersalurkan' => 165,
                    'db_name'         => 'opensid_tataba',
                    'lat'             => -1.480000,
                    'lng'             => 123.180000,
                ],
            ];

            $stmtTenantCheck = $pdo->prepare("SELECT id FROM diskominfo_tenants WHERE slug = ?");
            $stmtTenantInsert = $pdo->prepare("INSERT INTO diskominfo_tenants (
                nama_desa, slug, kecamatan, kode_desa, tipe_server, vendor_name, vendor_contact,
                url_portal, sla_target, uptime_pct, latency_ms, last_status, api_token,
                total_penduduk, total_kk, total_surat, apbdes_total, apbdes_realisasi,
                bansos_tersalurkan, db_name, lat, lng
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            foreach ($tenantsData as $td) {
                $stmtTenantCheck->execute([$td['slug']]);
                if (! $stmtTenantCheck->fetch()) {
                    $stmtTenantInsert->execute([
                        $td['nama_desa'], $td['slug'], $td['kecamatan'], $td['kode_desa'],
                        $td['tipe_server'], $td['vendor_name'], $td['vendor_contact'],
                        $td['url_portal'], $td['sla_target'], $td['uptime_pct'],
                        $td['latency_ms'], $td['last_status'], $td['api_token'],
                        $td['total_penduduk'], $td['total_kk'], $td['total_surat'],
                        $td['apbdes_total'], $td['apbdes_realisasi'], $td['bansos_tersalurkan'],
                        $td['db_name'], $td['lat'], $td['lng'],
                    ]);
                }
            }

            $this->info("   ✓ Data simpul desa awal berhasil dimuat ke 'diskominfo_tenants'.");

            $this->info('');
            $this->info('========================================================================');
            $this->info('🎉 PROVISIONING BASIS DATA DISKOMINFO BERHASIL!');
            $this->line(" • Basis Data        : {$targetDb}");
            $this->line(" • Username Admin    : {$adminUser}");
            $this->line(" • Password Admin    : {$adminPass}");
            $this->line(" • URL Admin         : http://148.230.102.95:8090/index.php/diskominfo/login");
            $this->info('========================================================================');

            return 0;
        } catch (Throwable $e) {
            $this->error("❌ Gagal melakukan inisialisasi basis data: " . $e->getMessage());
            return 1;
        }
    }
}
