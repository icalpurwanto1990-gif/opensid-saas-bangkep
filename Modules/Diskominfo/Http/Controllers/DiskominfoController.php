<?php

/*
 * Modul Diskominfo Command Center & SaaS Multi-Tenant
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\VillageMetric;

class DiskominfoController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Tampilan utama Diskominfo Command Center Kabupaten Banggai Kepulauan.
     */
    public function index()
    {
        try {
            // Pastikan view namespace 'diskominfo' terdaftar di container Blade
            $this->ensureViewNamespace();

            $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
            $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
            $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : null;

            // Data statistik demografi pilot desa Bobu vs total kecamatan
            $demografi = [
                'laki_laki'      => 742,
                'perempuan'      => 686,
                'usia_produktif' => 964,
                'lansia'         => 178,
                'balita'         => 146,
                'penerima_blt'   => 112,
                'penerima_pkh'   => 84,
                'penerima_bpnt'  => 96,
            ];

            // Indikator Pelayanan Surat Desa Bobu
            $pelayananSurat = [
                ['jenis' => 'Surat Keterangan Domisili', 'jumlah' => 45, 'status' => 'Selesai'],
                ['jenis' => 'Surat Keterangan Usaha (UMKM)', 'jumlah' => 28, 'status' => 'Selesai'],
                ['jenis' => 'Surat Pengantar SKCK', 'jumlah' => 19, 'status' => 'Selesai'],
                ['jenis' => 'Surat Keterangan Tidak Mampu (DTKS)', 'jumlah' => 34, 'status' => 'Selesai'],
                ['jenis' => 'Surat Kelahiran / Kematian', 'jumlah' => 12, 'status' => 'Selesai'],
            ];

            return view('diskominfo::dashboard', [
                'title'          => 'Command Center Diskominfo - Kab. Banggai Kepulauan',
                'summary'        => $summary,
                'tenants'        => $tenants,
                'pilotTenant'    => $pilotTenant,
                'demografi'      => $demografi,
                'pelayananSurat' => $pelayananSurat,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Dashboard Diskominfo');
        }
    }

    /**
     * Monitoring Daftar Tenant Desa SaaS
     *
     * @param string|null $slug
     */
    public function desa($slug = null)
    {
        try {
            $this->ensureViewNamespace();

            $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
            $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
            $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : null;
            $tenant      = null;

            if ($slug) {
                $tenant = class_exists(TenantManager::class) ? TenantManager::getTenantBySlug($slug) : null;

                if (! $tenant) {
                    show_404();
                }
            }

            return view('diskominfo::tenants.index', [
                'title'       => $tenant
                    ? 'Detail Monitoring Desa - ' . ($tenant['nama_desa'] ?? $slug)
                    : 'Monitoring Tenant Desa SaaS - Diskominfo Banggai Kepulauan',
                'tenants'     => $tenants,
                'summary'     => $summary,
                'pilotTenant' => $pilotTenant,
                'tenant'      => $tenant,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Monitoring Tenant Desa');
        }
    }

    /**
     * WebGIS Spasial Kabupaten Banggai Kepulauan
     */
    public function gis()
    {
        try {
            $this->ensureViewNamespace();

            $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
            $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
            $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : null;

            return view('diskominfo::gis.index', [
                'title'       => 'Peta WebGIS Tematik Spasial - Kab. Banggai Kepulauan',
                'summary'     => $summary,
                'tenants'     => $tenants,
                'pilotTenant' => $pilotTenant,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'WebGIS Spasial');
        }
    }

    /**
     * API Status Endpoint untuk live polling metrics
     */
    public function metrics()
    {
        $summary = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($summary));
    }

    /**
     * Mendaftarkan view namespace 'diskominfo' secara aman ke Blade engine.
     */
    protected function ensureViewNamespace(): void
    {
        $viewsPath = FCPATH . 'Modules/Diskominfo/Views';
        if (function_exists('app') && app()->bound('view') && is_dir($viewsPath)) {
            app('view')->addNamespace('diskominfo', $viewsPath);
        }
    }

    /**
     * Penanganan error dengan tampilan ramah developer daripada generic 500.
     */
    protected function handleException(\Throwable $e, string $context): void
    {
        if (function_exists('log_message')) {
            log_message('error', "{$context} Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        echo "<div style='font-family:-apple-system,BlinkMacSystemFont,\"Segoe UI\",Roboto,sans-serif;padding:2.5rem;background:#0a0f1d;color:#f8fafc;min-height:100vh;'>";
        echo "<div style='max-width:850px;margin:0 auto;background:#111827;border:1px solid rgba(244,63,94,0.3);border-radius:12px;padding:2rem;'>";
        echo "<h2 style='color:#f43f5e;margin-top:0;'>⚠️ Terjadi Kesalahan Saat Merender {$context}</h2>";
        echo "<p style='color:#e2e8f0;font-size:1.1rem;background:rgba(244,63,94,0.1);padding:0.75rem 1rem;border-radius:6px;border-left:4px solid #f43f5e;'><b>Detail:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p style='color:#94a3b8;font-size:0.9rem;'>Lokasi: <code>" . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</code></p>";
        echo "<details style='margin-top:1.5rem;'><summary style='color:#38bdf8;cursor:pointer;font-weight:600;'>Lihat Stack Trace</summary>";
        echo "<pre style='background:#030712;color:#a5f3fc;padding:1rem;border-radius:8px;overflow:auto;font-size:0.8rem;margin-top:0.75rem;line-height:1.5;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        echo "</details>";
        echo "</div>";
        echo "</div>";
    }
}
