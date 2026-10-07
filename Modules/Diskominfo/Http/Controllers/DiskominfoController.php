<?php

/*
 * Modul Diskominfo Command Center & SaaS Multi-Tenant
 * Kabupaten Banggai Kepulauan
 *
 * Controller ini berada di dalam folder modul agar dapat ditemukan oleh
 * HMVC router (donjo-app/third_party/MX/Router.php). Rute dengan
 * namespace 'Diskominfo' dikompilasi menjadi
 * 'Diskominfo/DiskominfoController/{method}', yang di-resolve ke
 * Modules/Diskominfo/Http/Controllers/DiskominfoController.php.
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\VillageMetric;

class DiskominfoController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // view() tanpa argumen mendaftarkan ViewServiceProvider dan mengembalikan factory,
        // sehingga namespace 'diskominfo::' selalu tersedia sebelum view dirender.
        $viewsPath = FCPATH . 'Modules/Diskominfo/Views';
        if (is_dir($viewsPath)) {
            view()->addNamespace('diskominfo', $viewsPath);
        }
    }

    /**
     * Tampilan utama Diskominfo Command Center Kabupaten Banggai Kepulauan.
     */
    public function index()
    {
        $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
        $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
        $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : [];

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
    }

    /**
     * Monitoring Daftar Tenant Desa SaaS
     *
     * @param string|null $slug
     */
    public function desa($slug = null)
    {
        $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
        $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
        $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : [];
        $tenant      = null;

        if ($slug) {
            $tenant = class_exists(TenantManager::class) ? TenantManager::getTenantBySlug($slug) : null;

            if (! $tenant) {
                show_404();
            }
        }

        return view('diskominfo::tenants.index', [
            'title'       => $tenant
                ? 'Detail Monitoring Desa - ' . ($tenant['name'] ?? $slug)
                : 'Monitoring Tenant Desa SaaS - Diskominfo Banggai Kepulauan',
            'tenants'     => $tenants,
            'summary'     => $summary,
            'pilotTenant' => $pilotTenant,
            'tenant'      => $tenant,
        ]);
    }

    /**
     * WebGIS Spasial Kabupaten Banggai Kepulauan
     */
    public function gis()
    {
        $summary     = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
        $tenants     = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
        $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : [];

        return view('diskominfo::gis.index', [
            'title'       => 'Peta WebGIS Tematik Spasial - Kab. Banggai Kepulauan',
            'summary'     => $summary,
            'tenants'     => $tenants,
            'pilotTenant' => $pilotTenant,
        ]);
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
}
