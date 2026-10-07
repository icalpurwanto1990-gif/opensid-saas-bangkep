<?php

/*
 * WebGIS Controller Diskominfo Command Center
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\VillageMetric;

class GisController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (function_exists('app') && app()->bound('view')) {
            $viewsPath = FCPATH . 'Modules' . DIRECTORY_SEPARATOR . 'Diskominfo' . DIRECTORY_SEPARATOR . 'Views';
            if (is_dir($viewsPath)) {
                app('view')->addNamespace('diskominfo', $viewsPath);
            }
        }
    }

    /**
     * WebGIS Peta Spasial Kabupaten Banggai Kepulauan & Sebaran Desa.
     */
    public function index()
    {
        $tenants = TenantManager::getRegisteredTenants();
        $pilotTenant = TenantManager::getDefaultPilotTenant();

        return view('diskominfo::gis', [
            'title'       => 'WebGIS Tematik & Spasial Desa - Kab. Banggai Kepulauan',
            'tenants'     => $tenants,
            'pilotTenant' => $pilotTenant,
        ]);
    }
}
