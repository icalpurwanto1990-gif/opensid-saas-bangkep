<?php

/*
 * Modul Diskominfo Command Center & SaaS Multi-Tenant
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\VillageMetric;

class Diskominfo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Register view namespace for Blade templates
        if (function_exists('app') && app()->bound('view')) {
            $viewsPath = FCPATH . 'Modules/Diskominfo/Views';
            if (is_dir($viewsPath)) {
                app('view')->addNamespace('diskominfo', $viewsPath);
            }
        }
    }

    /**
     * Tampilan utama Diskominfo Command Center Kabupaten Banggai Kepulauan.
     */
    public function index()
    {
        $summary = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
        $tenants = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
        $pilotTenant = class_exists(TenantManager::class) ? TenantManager::getDefaultPilotTenant() : [];

        // Data statistik demografi pilot desa Bobu vs total kecamatan
        $demografi = [
            'laki_laki' => 742,
            'perempuan' => 686,
            'usia_produktif' => 964,
            'lansia' => 178,
            'balita' => 146,
            'penerima_blt' => 112,
            'penerima_pkh' => 84,
            'penerima_bpnt' => 96,
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
     */
    public function desa($slug = null)
    {
        $tenants = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];
        $summary = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];

        if ($slug) {
            $tenant = class_exists(TenantManager::class) ? TenantManager::getTenantBySlug($slug) : null;
            $viewName = view()->exists('diskominfo::tenants.detail') ? 'diskominfo::tenants.detail' : 'diskominfo::tenants.index';
            return view($viewName, [
                'title'  => 'Detail Monitoring Desa - ' . ($tenant['name'] ?? $slug),
                'tenant' => $tenant,
            ]);
        }

        $viewName = view()->exists('diskominfo::tenants.index') ? 'diskominfo::tenants.index' : 'diskominfo::tenants';
        return view($viewName, [
            'title'   => 'Monitoring Tenant Desa SaaS - Diskominfo Banggai Kepulauan',
            'tenants' => $tenants,
            'summary' => $summary,
        ]);
    }

    /**
     * WebGIS Spasial Kabupaten Banggai Kepulauan
     */
    public function gis()
    {
        $summary = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
        $tenants = class_exists(TenantManager::class) ? TenantManager::getRegisteredTenants() : [];

        $viewName = view()->exists('diskominfo::gis.index') ? 'diskominfo::gis.index' : 'diskominfo::gis';
        return view($viewName, [
            'title'   => 'Peta WebGIS Tematik Spasial - Kab. Banggai Kepulauan',
            'summary' => $summary,
            'tenants' => $tenants,
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
