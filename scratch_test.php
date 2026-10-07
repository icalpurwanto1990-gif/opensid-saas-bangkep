<?php

require __DIR__ . '/vendor/autoload.php';

use App\Services\Tenancy\TenantManager;
use Modules\Diskominfo\Models\VillageMetric;

$pilot = TenantManager::getDefaultPilotTenant();
echo "SUCCESS: Pilot Village Loaded => " . $pilot->nama_desa . " (Kec. " . $pilot->kecamatan . ")" . PHP_EOL;
echo "Subdomain: " . $pilot->subdomain . " | DB: " . $pilot->db_name . PHP_EOL;

// Test Router
define('BASEPATH', 'dummy');
define('APPPATH', __DIR__ . '/donjo-app/');
define('FCPATH', __DIR__ . '/');
function is_cli() { return false; }
require_once __DIR__ . '/vendor/opensid/router/src/helpers.php';
require_once __DIR__ . '/vendor/opensid/router/src/Hook.php';
require_once __DIR__ . '/vendor/opensid/router/src/Facades/Route.php';

require_once __DIR__ . '/Modules/Diskominfo/Routes/web.php';
require_once __DIR__ . '/donjo-app/Routes/Web/diskominfo.php';

OpenSID\RouteBuilder::compileAll();
echo "SUCCESS: Route compile passed without errors!" . PHP_EOL;
$routes = getRoutes();
foreach ($routes as $path => $def) {
    if (strpos($path, 'diskominfo') !== false) {
        echo " - " . $path . " => " . json_encode($def) . PHP_EOL;
    }
}
