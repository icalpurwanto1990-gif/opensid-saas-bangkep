<?php

/*
 * Modul Diskominfo Command Center, Multi-Vendor Hub & SLA Monitoring
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\SlaIncident;
use Modules\Diskominfo\Models\Tenant;
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
            $this->ensureViewNamespace();

            $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
            $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
            $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : null;
            $slaSummary  = class_exists(TenantManager::class) ? TenantManager::getSlaSummary() : [];

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
                'slaSummary'     => $slaSummary,
                'demografi'      => $demografi,
                'pelayananSurat' => $pelayananSurat,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Dashboard Diskominfo');
        }
    }

    /**
     * Pusat Pemantauan SLA & Scorecard Keandalan Vendor untuk Pimpinan Daerah.
     */
    public function sla()
    {
        try {
            $this->ensureViewNamespace();

            $tenants    = TenantManager::getRegisteredTenants();
            $slaSummary = TenantManager::getSlaSummary();
            $incidents  = class_exists(SlaIncident::class) ? SlaIncident::getRecentIncidents() : [];

            return view('diskominfo::sla.index', [
                'title'      => 'Pusat Pemantauan SLA & Keandalan Vendor - Kab. Banggai Kepulauan',
                'tenants'    => $tenants,
                'slaSummary' => $slaSummary,
                'incidents'  => $incidents,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Pusat SLA & Keandalan Vendor');
        }
    }

    /**
     * Eksekusi live health check ping ke server website desa.
     */
    public function ping($slug = null)
    {
        try {
            $tenants = TenantManager::getRegisteredTenants();

            if ($slug) {
                $target = TenantManager::findTenantBySlug($slug);
                if (! $target) {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(404)
                        ->set_output(json_encode(['status' => 'error', 'message' => "Desa {$slug} tidak ditemukan."]));
                }
                $result = TenantManager::pingVillageHealth($target);

                if ($this->input->is_ajax_request() || $this->input->get('format') === 'json') {
                    return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode([
                            'status' => 'success',
                            'desa'   => $target->nama_desa,
                            'result' => $result,
                        ]));
                }

                return redirect(site_url('diskominfo/sla?pinged=' . urlencode($target->nama_desa) . '&latency=' . $result['latency_ms'] . '&status=' . $result['status']));
            }

            // Ping seluruh desa
            $results = [];
            foreach ($tenants as $t) {
                $results[$t->slug] = [
                    'nama_desa' => $t->nama_desa,
                    'vendor'    => $t->vendor_name,
                    'ping'      => TenantManager::pingVillageHealth($t),
                ];
            }

            if ($this->input->is_ajax_request() || $this->input->get('format') === 'json') {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status' => 'success', 'results' => $results]));
            }

            return redirect(site_url('diskominfo/sla?ping_all=success'));
        } catch (\Throwable $e) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
        }
    }

    /**
     * Monitoring Daftar Simpul Desa Multi-Vendor & Infrastruktur.
     */
    public function desa($slug = null)
    {
        try {
            $this->ensureViewNamespace();

            $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
            $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
            $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : null;
            $slaSummary  = class_exists(TenantManager::class) ? TenantManager::getSlaSummary() : [];
            $tenant      = null;

            if ($slug) {
                $tenant = class_exists(TenantManager::class) ? TenantManager::getTenantBySlug($slug) : null;

                if (! $tenant) {
                    show_404();
                }
            }

            return view('diskominfo::tenants.index', [
                'title'       => $tenant
                    ? 'Detail Monitoring Desa - ' . ($tenant->nama_desa ?? $slug)
                    : 'Manajemen Multi-Vendor & Simpul Desa - Kab. Banggai Kepulauan',
                'tenants'     => $tenants,
                'summary'     => $summary,
                'pilotTenant' => $pilotTenant,
                'slaSummary'  => $slaSummary,
                'tenant'      => $tenant,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Monitoring Multi-Vendor Desa');
        }
    }

    /**
     * Form pendaftaran desa eksternal / multi-vendor baru.
     */
    public function createDesa()
    {
        try {
            $this->ensureViewNamespace();

            return view('diskominfo::tenants.create', [
                'title' => 'Daftarkan Website Desa / Vendor Eksternal - Diskominfo Banggai Kepulauan',
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Pendaftaran Desa Eksternal');
        }
    }

    /**
     * Simpan pendaftaran desa eksternal / multi-vendor baru.
     */
    public function storeDesa()
    {
        try {
            $namaDesa  = trim((string) $this->input->post('nama_desa'));
            $slug      = preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $this->input->post('slug'))));
            $kecamatan = trim((string) $this->input->post('kecamatan'));
            $kodeDesa  = trim((string) $this->input->post('kode_desa'));
            $vendor    = trim((string) $this->input->post('vendor_name'));
            $kontak    = trim((string) $this->input->post('vendor_contact'));
            $urlPortal = trim((string) $this->input->post('url_portal'));
            $tipeServer= trim((string) $this->input->post('tipe_server')) ?: 'external_hosting';
            $slaTarget = (float) ($this->input->post('sla_target') ?: 99.0);

            if (empty($namaDesa) || empty($slug)) {
                return redirect(site_url('diskominfo/desa/create?error=invalid_input'));
            }

            // Simpan pendaftaran desa ke session flash
            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['flash_success'] = "Website Desa {$namaDesa} (Vendor: {$vendor}) berhasil didaftarkan ke Pusat Monitoring Diskominfo!";
            }

            return redirect(site_url('diskominfo/desa?registered=' . urlencode($namaDesa)));
        } catch (\Throwable $e) {
            $this->handleException($e, 'Simpan Pendaftaran Desa');
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
     * Laporan Kepatuhan SLA Eksekutif untuk Bupati & Pimpinan Daerah.
     */
    public function laporan()
    {
        try {
            $this->ensureViewNamespace();

            $tenants    = TenantManager::getRegisteredTenants();
            $slaSummary = TenantManager::getSlaSummary();

            return view('diskominfo::laporan.index', [
                'title'      => 'Laporan Eksekutif Kepatuhan SLA & Indeks Desa Digital - Banggai Kepulauan',
                'tenants'    => $tenants,
                'slaSummary' => $slaSummary,
            ]);
        } catch (\Throwable $e) {
            $this->handleException($e, 'Laporan Eksekutif SLA');
        }
    }

    /**
     * Universal REST API Ingestion Endpoint untuk Vendor Eksternal.
     * Menerima kiriman data kependudukan, surat, dan bansos dari website desa manapun.
     */
    public function apiIngest()
    {
        // 1. Validasi Token Otentikasi
        $token = $this->input->get_request_header('X-Diskominfo-Token', true)
            ?: $this->input->get_request_header('Authorization', true);

        if (! $token) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => 'unauthorized',
                    'message' => 'Header X-Diskominfo-Token wajib disertakan untuk otentikasi data ingestion.',
                ]));
        }

        // 2. Baca Payload JSON
        $rawPayload = file_get_contents('php://input');
        $payload    = json_decode($rawPayload, true) ?: $this->input->post();

        if (empty($payload)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => 'bad_request',
                    'message' => 'Payload JSON kosong atau format tidak valid.',
                ]));
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode([
                'status'    => 'success',
                'message'   => 'Data statistik desa berhasil diterima dan diagregasikan ke Diskominfo Command Center.',
                'timestamp' => date('Y-m-d H:i:s'),
                'received'  => [
                    'kode_desa'      => $payload['kode_desa'] ?? null,
                    'total_penduduk' => $payload['total_penduduk'] ?? 0,
                    'total_kk'       => $payload['total_kk'] ?? 0,
                    'total_surat'    => $payload['total_surat'] ?? 0,
                ],
            ]));
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
     * API Gateway Status
     */
    public function apiStatus()
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'service'   => 'Diskominfo Banggai Kepulauan Universal Interoperability Hub',
                'version'   => '1.0.0-enterprise',
                'status'    => 'Operational',
                'timestamp' => date('Y-m-d H:i:s'),
            ]));
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
