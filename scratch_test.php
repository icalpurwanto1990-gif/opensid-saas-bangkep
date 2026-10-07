<?php

require __DIR__ . '/vendor/autoload.php';

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\VillageMetric;

$pilot = TenantManager::getDefaultPilotTenant();
echo "SUCCESS: Pilot Village Loaded => " . $pilot->nama_desa . " (Kec. " . $pilot->kecamatan . ")" . PHP_EOL;
echo "Subdomain: " . $pilot->subdomain . " | DB: " . $pilot->db_name . PHP_EOL;

$allTenants = TenantManager::getRegisteredTenants();
echo "Total Registered Tenants: " . count($allTenants) . PHP_EOL;

$summary = VillageMetric::getKabupatenSummary();
echo "Kabupaten: Banggai Kepulauan (" . $summary['total_desa'] . " Desa)" . PHP_EOL;
