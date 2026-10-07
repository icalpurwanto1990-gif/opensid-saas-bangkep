<?php

/*
 * Dashboard Controller Diskominfo Command Center
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\Tenant;
use Modules\Diskominfo\Models\VillageMetric;

class DashboardController extends CI_Controller
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
     * API Status Endpoint untuk live polling metrics oleh dashboard
     */
    public function apiMetrics()
    {
        $summary = class_exists(VillageMetric::class) ? VillageMetric::getKabupatenSummary() : [];
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($summary));
    }
}
