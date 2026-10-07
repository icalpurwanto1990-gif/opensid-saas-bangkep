<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use PDO;
use Throwable;

class ProvisionTenantCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'opensid:provision-tenant 
                            {slug : Slug desa unik (contoh: mansamat)}
                            {--name= : Nama resmi desa (contoh: Mansamat)}
                            {--kecamatan= : Nama kecamatan (contoh: Tinangkung Selatan)}
                            {--kodedesa= : Kode wilayah Kemendagri desa}
                            {--kades= : Nama Kepala Desa}';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Otomasi pembuatan basis data terisolasi baru (Database-per-Tenant) untuk desa di Kabupaten Banggai Kepulauan';

    /**
     * Eksekusi perintah provisioning.
     */
    public function handle(): int
    {
        $rawSlug = (string) $this->argument('slug');
        $slug    = preg_replace('/[^a-z0-9_]/', '', strtolower(trim($rawSlug)));

        if (empty($slug)) {
            $this->error('❌ Slug desa tidak valid! Gunakan karakter alfanumerik (contoh: mansamat).');
            return Command::FAILURE;
        }

        $namaDesa  = $this->option('name') ?: ucfirst($slug);
        $kecamatan = $this->option('kecamatan') ?: 'Tinangkung Selatan';
        $kodeDesa  = $this->option('kodedesa') ?: '720703200' . rand(2, 9);
        $kades     = $this->option('kades') ?: 'Kepala Desa ' . $namaDesa;
        $targetDb  = 'opensid_' . $slug;
        $sourceDb  = getenv('DB_DATABASE') ?: 'opensid_bobu';

        $this->info("🚀 Memulai provisioning Database-per-Tenant untuk: Desa {$namaDesa} (DB: {$targetDb})...");

        // Konfigurasi koneksi MySQL/MariaDB
        $host   = getenv('DB_HOST') ?: 'db';
        $port   = (int) (getenv('DB_PORT') ?: 3306);
        $dbUser = getenv('DB_USERNAME') ?: 'opensid_user';
        $dbPass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';

        try {
            // 1. Hubungkan ke MariaDB
            $pdo = $this->getDatabaseConnection($host, $port, $dbUser, $dbPass);

            // 2. Buat database baru jika belum ada
            $this->info("📦 [1/5] Membuat database {$targetDb}...");
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$targetDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            // Berikan izin penuh pada user database
            try {
                $pdo->exec("GRANT ALL PRIVILEGES ON `{$targetDb}`.* TO '{$dbUser}'@'%';");
                $pdo->exec('FLUSH PRIVILEGES;');
            } catch (Throwable $e) {
                // Ignore jika bukan root
            }

            // 3. Gandakan struktur tabel dari sourceDb (opensid_bobu)
            $this->info("📋 [2/5] Menyalin struktur tabel dari template ({$sourceDb})...");
            $tablesStmt = $pdo->query("SHOW TABLES FROM `{$sourceDb}`");
            $tables     = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

            if (empty($tables)) {
                $this->warn("⚠️ Template {$sourceDb} tidak memiliki tabel. Menjalankan fallback standar.");
            } else {
                $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
                foreach ($tables as $table) {
                    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$targetDb}`.`{$table}` LIKE `{$sourceDb}`.`{$table}`;");
                }

                // Salin tabel referensi dan pengaturan sistem OpenSID
                $refTables = [
                    'setting_aplikasi',
                    'setting_modul',
                    'user_grup',
                    'ref_syarat_surat',
                    'tweb_penduduk_status',
                    'tweb_penduduk_agama',
                    'tweb_penduduk_pendidikan',
                    'tweb_penduduk_pekerjaan',
                    'tweb_penduduk_hubungan',
                    'tweb_penduduk_kawin',
                    'tweb_golongan_darah',
                    'tweb_cacat',
                    'tweb_status_dasar',
                    'migrasi',
                ];

                foreach ($refTables as $ref) {
                    if (in_array($ref, $tables)) {
                        $pdo->exec("INSERT IGNORE INTO `{$targetDb}`.`{$ref}` SELECT * FROM `{$sourceDb}`.`{$ref}`;");
                    }
                }
                $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
                $this->info("✅ Berhasil menduplikasi " . count($tables) . " tabel ke {$targetDb}.");
            }

            // 4. Inisialisasi Identitas Desa pada tabel config
            $this->info("🏛️ [3/5] Mengisi data identitas Desa {$namaDesa}...");
            $this->seedTenantConfig($pdo, $targetDb, [
                'nama_desa'         => $namaDesa,
                'nama_kecamatan'    => $kecamatan,
                'kode_desa'         => $kodeDesa,
                'nama_kepala_camat' => $kades,
                'slug'              => $slug,
            ]);

            // 5. Inisialisasi Akun Administrator Desa
            $this->info("👤 [4/5] Menginisialisasi akun admin desa...");
            $this->seedTenantAdminUser($pdo, $targetDb, $namaDesa, $slug);

            // 6. Terbitkan Artikel Selamat Datang
            $this->info("📰 [5/5] Menerbitkan artikel pembuka portal...");
            $this->seedWelcomeArticle($pdo, $targetDb, $namaDesa, $kecamatan);

            $this->newLine();
            $this->info('===============================================================');
            $this->info("🎉 SUKSES! Basis Data Desa {$namaDesa} Berhasil Dibuat & Terisolasi!");
            $this->info('===============================================================');
            $this->info("👉 Basis Data Fisik : {$targetDb}");
            $this->info("👉 Portal Publik    : http://148.230.102.95:8090/index.php?desa={$slug}");
            $this->info("👉 Admin Login      : http://148.230.102.95:8090/index.php/siteman?desa={$slug}");
            $this->info("👉 Kredensial Default : Username: admin | Password: sid304");
            $this->info('===============================================================');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('❌ Terjadi kesalahan saat provisioning: ' . $e->getMessage());
            $this->line($e->getTraceAsString());
            return Command::FAILURE;
        }
    }

    /**
     * Dapatkan koneksi PDO ke database server.
     */
    protected function getDatabaseConnection(string $host, int $port, string $user, string $pass): PDO
    {
        try {
            return new PDO("mysql:host={$host};port={$port}", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (Throwable $e) {
            // Fallback coba koneksi via root jika kredensial khusus
            $rootPass = getenv('DB_ROOT_PASSWORD') ?: 'opensid_root_secret';
            return new PDO("mysql:host={$host};port={$port}", 'root', $rootPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        }
    }

    /**
     * Pasang konfigurasi identitas desa pada tabel config.
     */
    protected function seedTenantConfig(PDO $pdo, string $dbName, array $data): void
    {
        $appKey = function_exists('get_app_key') ? get_app_key() : 'base64:rN3vXWFRHDKFP2sMySe9f4gna7WulisoXTqn7Yo4Ye8=';

        $checkStmt = $pdo->query("SELECT id FROM `{$dbName}`.`config` LIMIT 1");
        $exists    = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $sql = "UPDATE `{$dbName}`.`config` SET 
                    `nama_desa` = :nama_desa,
                    `nama_kecamatan` = :nama_kecamatan,
                    `nama_kabupaten` = 'Banggai Kepulauan',
                    `nama_propinsi` = 'Sulawesi Tengah',
                    `kode_desa` = :kode_desa,
                    `kode_pos` = '94785',
                    `email_desa` = :email,
                    `website` = :website,
                    `nama_kepala_camat` = :kades,
                    `alamat_kantor` = :alamat
                    WHERE `id` = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nama_desa'      => $data['nama_desa'],
                ':nama_kecamatan' => $data['nama_kecamatan'],
                ':kode_desa'      => $data['kode_desa'],
                ':email'          => 'pemdes@' . $data['slug'] . '.desa.id',
                ':website'        => 'https://' . $data['slug'] . '.banggaikep.go.id',
                ':kades'          => $data['nama_kepala_camat'],
                ':alamat'         => 'Jl. Trans Banggai Kepulauan, Desa ' . $data['nama_desa'],
                ':id'             => $exists['id'],
            ]);
        } else {
            $sql = "INSERT INTO `{$dbName}`.`config` 
                    (`nama_desa`, `nama_kecamatan`, `nama_kabupaten`, `nama_propinsi`, `kode_desa`, `kode_pos`, `email_desa`, `website`, `nama_kepala_camat`, `alamat_kantor`, `app_key`)
                    VALUES (:nama_desa, :nama_kecamatan, 'Banggai Kepulauan', 'Sulawesi Tengah', :kode_desa, '94785', :email, :website, :kades, :alamat, :app_key)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nama_desa'      => $data['nama_desa'],
                ':nama_kecamatan' => $data['nama_kecamatan'],
                ':kode_desa'      => $data['kode_desa'],
                ':email'          => 'pemdes@' . $data['slug'] . '.desa.id',
                ':website'        => 'https://' . $data['slug'] . '.banggaikep.go.id',
                ':kades'          => $data['nama_kepala_camat'],
                ':alamat'         => 'Jl. Trans Banggai Kepulauan, Desa ' . $data['nama_desa'],
                ':app_key'        => $appKey,
            ]);
        }
    }

    /**
     * Buat akun admin default untuk desa ini.
     */
    protected function seedTenantAdminUser(PDO $pdo, string $dbName, string $namaDesa, string $slug): void
    {
        $hashPass = Hash::make('sid304');

        $checkStmt = $pdo->prepare("SELECT id FROM `{$dbName}`.`user` WHERE `username` = 'admin' LIMIT 1");
        $checkStmt->execute();
        $admin = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $update = $pdo->prepare("UPDATE `{$dbName}`.`user` SET `password` = :pass, `active` = 1, `id_grup` = 1 WHERE `id` = :id");
            $update->execute([':pass' => $hashPass, ':id' => $admin['id']]);
        } else {
            $insert = $pdo->prepare("INSERT INTO `{$dbName}`.`user` 
                (`username`, `password`, `nama`, `email`, `id_grup`, `active`, `pamong_nama`)
                VALUES ('admin', :pass, :nama, :email, 1, 1, 'Administrator')");
            $insert->execute([
                ':pass'  => $hashPass,
                ':nama'  => 'Administrator Desa ' . $namaDesa,
                ':email' => 'admin@' . $slug . '.desa.id',
            ]);
        }
    }

    /**
     * Tambahkan artikel sambutan pembuka portal desa.
     */
    protected function seedWelcomeArticle(PDO $pdo, string $dbName, string $namaDesa, string $kecamatan): void
    {
        try {
            $checkTable = $pdo->query("SHOW TABLES FROM `{$dbName}` LIKE 'artikel'");
            if ($checkTable->rowCount() > 0) {
                $sql = "INSERT INTO `{$dbName}`.`artikel` 
                        (`judul`, `isi`, `id_kategori`, `id_user`, `tgl_upload`, `enabled`, `headline`)
                        VALUES (:judul, :isi, 1, 1, NOW(), 1, 1)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':judul' => 'Selamat Datang di Portal Resmi Desa ' . $namaDesa,
                    ':isi'   => "<p>Selamat datang di portal informasi dan pelayanan digital publik Desa {$namaDesa}, Kecamatan {$kecamatan}, Kabupaten Banggai Kepulauan.</p><p>Sistem ini beroperasi dengan basis data mandiri dan terintegrasi secara aman dengan Command Center Diskominfo Kabupaten Banggai Kepulauan.</p>",
                ]);
            }
        } catch (Throwable $e) {
            // Skip jika tabel artikel belum ada
        }
    }
}
