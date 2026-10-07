<?php

/*
 * Tenant Controller Diskominfo Command Center
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\Tenant;

class TenantController extends CI_Controller
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
     * Daftar seluruh desa yang terpantau di Banggai Kepulauan.
     */
    public function index()
    {
        $tenants = TenantManager::getRegisteredTenants();
        $pilotTenant = TenantManager::getDefaultPilotTenant();

        return view('diskominfo::tenants', [
            'title'       => 'Daftar Tenant Desa SaaS - Banggai Kepulauan',
            'tenants'     => $tenants,
            'pilotTenant' => $pilotTenant,
        ]);
    }

    /**
     * Detail monitoring spesifik satu desa.
     */
    public function show($slug)
    {
        $tenant = TenantManager::getTenantBySlug($slug);

        if (! $tenant) {
            show_404();
        }

        return view('diskominfo::tenant_detail', [
            'title'  => 'Monitoring Desa: ' . $tenant['name'],
            'tenant' => $tenant,
        ]);
    }
}
