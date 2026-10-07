<?php

namespace App\Services\Tenancy;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Modules\Diskominfo\Models\Tenant;

class TenantManager
{
    /**
     * Tenant aktif saat ini.
     *
     * @var Tenant|null
     */
    protected static ?Tenant $currentTenant = null;

    /**
     * Resolusi dan tentukan tenant berdasarkan HTTP Request.
     * Mendukung:
     * 1. Subdomain / Host (contoh: bobu.banggaikep.go.id, bobu.desa.id)
     * 2. Query param untuk local dev / testing (?desa=bobu atau ?tenant=bobu)
     * 3. Header X-Tenant-Id
     */
    public static function resolveFromRequest(): ?Tenant
    {
        if (static::$currentTenant !== null) {
            return static::$currentTenant;
        }

        $slug = null;

        // 1. Cek parameter URL (sangat berguna untuk development lokal)
        if (isset($_GET['desa']) && ! empty($_GET['desa'])) {
            $slug = strtolower(trim((string) $_GET['desa']));
        } elseif (isset($_GET['tenant']) && ! empty($_GET['tenant'])) {
            $slug = strtolower(trim((string) $_GET['tenant']));
        }

        // 2. Cek Header Request
        if (! $slug && isset($_SERVER['HTTP_X_TENANT_ID'])) {
            $slug = strtolower(trim((string) $_SERVER['HTTP_X_TENANT_ID']));
        }

        // 3. Cek Host / Subdomain
        if (! $slug && isset($_SERVER['HTTP_HOST'])) {
            $host = strtolower($_SERVER['HTTP_HOST']);
            $parts = explode('.', $host);
            // Jika host berbentuk subdomain (contoh: bobu.banggaikep.go.id -> 'bobu')
            if (count($parts) >= 3 && ! in_array($parts[0], ['www', 'diskominfo', 'admin', 'api', 'localhost'])) {
                $slug = $parts[0];
            }
        }

        // Jika ditemukan slug, cari data tenant
        if ($slug) {
            static::$currentTenant = static::findTenantBySlug($slug);
        }

        // Default fallback ke Desa Pilot (Desa Bobu) jika dipanggil dalam konteks default Banggai Kepulauan
        if (! static::$currentTenant && $slug === 'bobu') {
            static::$currentTenant = static::getDefaultPilotTenant();
        }

        return static::$currentTenant;
    }

    /**
     * Dapatkan data tenant aktif.
     */
    public static function current(): ?Tenant
    {
        return static::$currentTenant ?? static::resolveFromRequest();
    }

    /**
     * Set tenant secara manual.
     */
    public static function setTenant(Tenant $tenant): void
    {
        static::$currentTenant = $tenant;
        static::applyTenantDatabaseConnection($tenant);
    }

    /**
     * Terapkan konfigurasi database dinamis untuk tenant.
     */
    public static function applyTenantDatabaseConnection(Tenant $tenant): void
    {
        if (! empty($tenant->db_name)) {
            Config::set('database.connections.tenant', [
                'driver'    => 'mysql',
                'host'      => $tenant->db_host ?? (getenv('DB_HOST') ?: '127.0.0.1'),
                'port'      => $tenant->db_port ?? (getenv('DB_PORT') ?: '3306'),
                'database'  => $tenant->db_name,
                'username'  => $tenant->db_username ?? (getenv('DB_USERNAME') ?: 'root'),
                'password'  => $tenant->db_password ?? (getenv('DB_PASSWORD') ?: ''),
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'    => $tenant->db_prefix ?? '',
                'strict'    => false,
            ]);

            DB::purge('tenant');
        }
    }

    /**
     * Cari tenant berdasarkan slug atau kode desa.
     */
    public static function findTenantBySlug(string $slug): ?Tenant
    {
        // Jika tabel tenant di database belum siap, gunakan in-memory repository
        $tenants = static::getRegisteredTenants();

        foreach ($tenants as $item) {
            if ($item->slug === $slug || $item->kode_desa === $slug) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Daftar desa yang terdaftar di Kabupaten Banggai Kepulauan.
     *
     * @return Tenant[]
     */
    public static function getRegisteredTenants(): array
    {
        return [
            new Tenant([
                'id'              => 1,
                'nama_desa'       => 'Desa Bobu',
                'slug'            => 'bobu',
                'subdomain'       => 'bobu.banggaikep.go.id',
                'custom_domain'   => 'bobu.desa.id',
                'kecamatan'       => 'Tinangkung Selatan',
                'kabupaten'       => 'Banggai Kepulauan',
                'provinsi'        => 'Sulawesi Tengah',
                'kode_desa'       => '72.07.03.2001',
                'kode_pos'        => '94785',
                'nama_kepala_desa'=> 'Ilyas M. Tadja',
                'status'          => 'Aktif',
                'versi_opensid'   => '2607.0.1',
                'total_penduduk'  => 1428,
                'total_kk'        => 386,
                'status_server'   => 'Online',
                'terakhir_sync'   => date('Y-m-d H:i:s'),
                'db_name'         => 'opensid_bobu',
                'lat'             => -1.385200,
                'lng'             => 123.321400,
            ]),
            new Tenant([
                'id'              => 2,
                'nama_desa'       => 'Desa Mansamat',
                'slug'            => 'mansamat',
                'subdomain'       => 'mansamat.banggaikep.go.id',
                'custom_domain'   => 'mansamat.desa.id',
                'kecamatan'       => 'Tinangkung Selatan',
                'kabupaten'       => 'Banggai Kepulauan',
                'provinsi'        => 'Sulawesi Tengah',
                'kode_desa'       => '72.07.03.2002',
                'kode_pos'        => '94785',
                'nama_kepala_desa'=> 'Rahman Sudin',
                'status'          => 'Aktif',
                'versi_opensid'   => '2607.0.1',
                'total_penduduk'  => 1150,
                'total_kk'        => 312,
                'status_server'   => 'Online',
                'terakhir_sync'   => date('Y-m-d H:i:s', strtotime('-15 minutes')),
                'db_name'         => 'opensid_mansamat',
                'lat'             => -1.412100,
                'lng'             => 123.345000,
            ]),
            new Tenant([
                'id'              => 3,
                'nama_desa'       => 'Desa Paisumosoni',
                'slug'            => 'paisumosoni',
                'subdomain'       => 'paisumosoni.banggaikep.go.id',
                'custom_domain'   => 'paisumosoni.desa.id',
                'kecamatan'       => 'Tinangkung Selatan',
                'kabupaten'       => 'Banggai Kepulauan',
                'provinsi'        => 'Sulawesi Tengah',
                'kode_desa'       => '72.07.03.2003',
                'kode_pos'        => '94785',
                'nama_kepala_desa'=> 'Sukardi L.',
                'status'          => 'Aktif',
                'versi_opensid'   => '2607.0.1',
                'total_penduduk'  => 980,
                'total_kk'        => 270,
                'status_server'   => 'Online',
                'terakhir_sync'   => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'db_name'         => 'opensid_paisumosoni',
                'lat'             => -1.430000,
                'lng'             => 123.360000,
            ]),
            new Tenant([
                'id'              => 4,
                'nama_desa'       => 'Desa Salakan',
                'slug'            => 'salakan',
                'subdomain'       => 'salakan.banggaikep.go.id',
                'custom_domain'   => 'salakan.desa.id',
                'kecamatan'       => 'Tinangkung',
                'kabupaten'       => 'Banggai Kepulauan',
                'provinsi'        => 'Sulawesi Tengah',
                'kode_desa'       => '72.07.01.2001',
                'kode_pos'        => '94785',
                'nama_kepala_desa'=> 'Zulkifli Abdullah',
                'status'          => 'Aktif',
                'versi_opensid'   => '2607.0.1',
                'total_penduduk'  => 3240,
                'total_kk'        => 890,
                'status_server'   => 'Online',
                'terakhir_sync'   => date('Y-m-d H:i:s', strtotime('-5 minutes')),
                'db_name'         => 'opensid_salakan',
                'lat'             => -1.309000,
                'lng'             => 123.298000,
            ]),
        ];
    }

    /**
     * Tenant default percontohan (Pilot Desa Bobu).
     */
    public static function getDefaultPilotTenant(): Tenant
    {
        $tenants = static::getRegisteredTenants();
        return $tenants[0];
    }
}
