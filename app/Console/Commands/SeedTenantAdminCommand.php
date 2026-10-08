<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use Throwable;

class SeedTenantAdminCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'opensid:seed-tenant-admin 
                            {slug : Slug desa target (misal: bobu, mansamat)} 
                            {--user=admin : Username admin desa} 
                            {--pass=Bobu@2026! : Password admin desa} 
                            {--nama= : Nama lengkap admin} 
                            {--email= : Email admin}';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Buat atau atur ulang kredensial admin desa mandiri dan identitas domain di database tenant masing-masing';

    /**
     * Eksekusi perintah seeder admin desa.
     */
    public function handle(): int
    {
        $rawSlug = strtolower(trim((string) $this->argument('slug')));
        $slug    = preg_replace('/[^a-z0-9_]/', '', $rawSlug);
        $user    = trim((string) $this->option('user')) ?: 'admin';
        $pass    = trim((string) $this->option('pass')) ?: 'Bobu@2026!';
        $nama    = trim((string) $this->option('nama')) ?: 'Administrator ' . ucfirst($slug);
        $email   = trim((string) $this->option('email')) ?: 'admin@' . $slug . '-tinangkungselatan.desa.id';

        $host   = getenv('DB_HOST') ?: 'db';
        $port   = (int) (getenv('DB_PORT') ?: 3306);
        $dbUser = getenv('DB_USERNAME') ?: 'opensid_user';
        $dbPass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';
        $dbName = 'opensid_' . $slug;

        $this->info('========================================================================');
        $this->info("  PENGATURAN ADMIN MANDIRI & IDENTITAS DESA [{$slug}]");
        $this->info('========================================================================');

        try {
            $pdo = new PDO("mysql:host={$host};port={$port}", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // 1. Cek atau buat database opensid_{slug}
            $stmt = $pdo->query("SHOW DATABASES LIKE '{$dbName}'");
            if (! $stmt->fetch()) {
                $this->warn("⚠️ Basis data '{$dbName}' belum ada. Membuat basis data baru...");
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            }

            $pdo->exec("USE `{$dbName}`");
            $this->info("🔌 Tersambung ke basis data terisolasi: {$dbName}");

            // 2. Perbarui identitas desa di tabel config jika ada
            $checkTable = $pdo->query("SHOW TABLES LIKE 'config'")->fetch();
            if ($checkTable) {
                if ($slug === 'bobu') {
                    $pdo->exec("UPDATE `config` SET 
                        `nama_desa` = 'Bobu',
                        `nama_kecamatan` = 'Tinangkung Selatan',
                        `nama_kabupaten` = 'Banggai Kepulauan',
                        `nama_propinsi` = 'Sulawesi Tengah',
                        `kode_pos` = '94785',
                        `kode_desa` = '7207032001',
                        `email_desa` = 'pemdes@bobu-tinangkungselatan.desa.id',
                        `website` = 'http://bobu-tinangkungselatan.desa.id',
                        `nama_kepala_camat` = 'Ilyas M. Tadja'
                        LIMIT 1");
                    $this->info("🏢 Identitas kantor Desa Bobu dan domain resmi diperbarui di tabel 'config'.");
                }
            }

            // 3. Pastikan tabel user tersedia dan daftarkan / perbarui admin desa
            $checkUserTable = $pdo->query("SHOW TABLES LIKE 'user'")->fetch();
            if ($checkUserTable) {
                $hash = password_hash($pass, PASSWORD_BCRYPT);

                $stmtUser = $pdo->prepare("SELECT id FROM `user` WHERE `username` = ? LIMIT 1");
                $stmtUser->execute([$user]);
                $existing = $stmtUser->fetch();

                if ($existing) {
                    $pdo->prepare("UPDATE `user` SET `password` = ?, `active` = 1, `nama` = ?, `email` = ? WHERE `id` = ?")
                        ->execute([$hash, $nama, $email, $existing['id']]);
                    $this->info("🔑 Password admin '{$user}' di basis data {$dbName} berhasil diperbarui.");
                } else {
                    $pdo->prepare("INSERT INTO `user` (`username`, `password`, `id_grup`, `email`, `nama`, `active`) VALUES (?, ?, 1, ?, ?, 1)")
                        ->execute([$user, $hash, $email, $nama]);
                    $this->info("👤 Akun admin baru '{$user}' berhasil didaftarkan di basis data {$dbName}.");
                }
            } else {
                $this->warn("⚠️ Tabel 'user' belum ada di {$dbName}. Jika ini instalasi baru, jalankan migrasi schema desa.");
            }

            // 4. Perbarui data domain pada registry opensid_diskominfo jika tersedia
            try {
                $checkDiskominfo = $pdo->query("SHOW DATABASES LIKE 'opensid_diskominfo'")->fetch();
                if ($checkDiskominfo) {
                    $pdo->exec("USE `opensid_diskominfo`");
                    $pdo->prepare("UPDATE `diskominfo_tenants` SET `url_portal` = ?, `custom_domain` = ? WHERE `slug` = ?")
                        ->execute([
                            'http://bobu-tinangkungselatan.desa.id:8090',
                            'bobu-tinangkungselatan.desa.id',
                            $slug,
                        ]);
                    $this->info("🌐 Domain 'bobu-tinangkungselatan.desa.id' tersinkronisasi di Diskominfo Command Center.");
                }
            } catch (Throwable $e) {}

            $this->info('');
            $this->table(
                ['Parameter', 'Keterangan'],
                [
                    ['Desa', ucfirst($slug)],
                    ['Basis Data Fisik', $dbName],
                    ['Username Admin Desa', $user],
                    ['Password Admin Desa', $pass],
                    ['Domain Resmi Desa', "bobu-tinangkungselatan.desa.id:8090"],
                    ['URL Login Mandiri Desa (Domain)', "http://bobu-tinangkungselatan.desa.id:8090/index.php/siteman"],
                    ['URL Login Alternatif (IP VPS)', "http://148.230.102.95:8090/index.php/siteman?desa={$slug}"],
                    ['Portal Publik Desa', "http://bobu-tinangkungselatan.desa.id:8090"],
                ]
            );

            return 0;
        } catch (Throwable $e) {
            $this->error("❌ Terjadi kesalahan: " . $e->getMessage());
            return 1;
        }
    }
}
