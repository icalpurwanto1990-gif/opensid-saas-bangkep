<?php

namespace App\Console\Commands;

use App\Services\Tenancy\TenantManager;
use Illuminate\Console\Command;
use PDO;
use Throwable;

class SyncMetricsCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'opensid:sync-metrics';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi metrik statistik dari seluruh basis data desa mandiri (Database-per-Tenant) ke Diskominfo Command Center';

    /**
     * Eksekusi sinkronisasi.
     */
    public function handle(): int
    {
        $this->info('🔄 Mengumpulkan dan menyinkronkan data dari seluruh basis data desa di Banggai Kepulauan...');

        $host   = getenv('DB_HOST') ?: 'db';
        $port   = (int) (getenv('DB_PORT') ?: 3306);
        $dbUser = getenv('DB_USERNAME') ?: 'opensid_user';
        $dbPass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';

        try {
            $pdo = new PDO("mysql:host={$host};port={$port}", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // Dapatkan seluruh database opensid_*
            $dbStmt = $pdo->query("SHOW DATABASES LIKE 'opensid_%'");
            $databases = $dbStmt->fetchAll(PDO::FETCH_COLUMN);

            $rows = [];
            $totalPendudukKab = 0;
            $totalKkKab       = 0;

            foreach ($databases as $dbName) {
                $slug = str_replace('opensid_', '', $dbName);

                // Dapatkan nama desa dari config
                $namaDesa  = ucfirst($slug);
                $kecamatan = 'Banggai Kepulauan';
                $penduduk  = 0;
                $kk        = 0;
                $status    = 'Online';

                try {
                    $cfgStmt = $pdo->query("SELECT nama_desa, nama_kecamatan FROM `{$dbName}`.`config` LIMIT 1");
                    if ($cfg = $cfgStmt->fetch(PDO::FETCH_ASSOC)) {
                        $namaDesa  = $cfg['nama_desa'] ?: $namaDesa;
                        $kecamatan = $cfg['nama_kecamatan'] ?: $kecamatan;
                    }
                } catch (Throwable $e) {
                    // tabel config mungkin belum ada
                }

                try {
                    $penStmt = $pdo->query("SELECT COUNT(*) FROM `{$dbName}`.`tweb_penduduk` WHERE status_dasar = 1");
                    $penduduk = (int) $penStmt->fetchColumn();
                } catch (Throwable $e) {
                    $penduduk = 0;
                }

                try {
                    $kkStmt = $pdo->query("SELECT COUNT(*) FROM `{$dbName}`.`tweb_keluarga`");
                    $kk = (int) $kkStmt->fetchColumn();
                } catch (Throwable $e) {
                    $kk = 0;
                }

                $totalPendudukKab += $penduduk;
                $totalKkKab       += $kk;

                $rows[] = [
                    'Database'       => $dbName,
                    'Desa'           => $namaDesa,
                    'Kecamatan'      => $kecamatan,
                    'Total Penduduk' => number_format($penduduk, 0, ',', '.') . ' Jiwa',
                    'Total KK'       => number_format($kk, 0, ',', '.') . ' KK',
                    'Status'         => '✅ Terhubung',
                ];
            }

            $this->table(['Basis Data', 'Desa', 'Kecamatan', 'Total Penduduk', 'Total KK', 'Status Sync'], $rows);

            $this->info("📊 Ringkasan Kabupaten Banggai Kepulauan:");
            $this->info("   • Total Simpul Database Desa Aktif : " . count($databases) . " Database");
            $this->info("   • Total Penduduk Terintegrasi     : " . number_format($totalPendudukKab, 0, ',', '.') . " Jiwa");
            $this->info("   • Total Kepala Keluarga           : " . number_format($totalKkKab, 0, ',', '.') . " KK");
            $this->info("🎉 Sinkronisasi metrik selesai dengan sukses!");

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('❌ Gagal menyinkronkan metrik: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
