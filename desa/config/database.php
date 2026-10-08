<?php

/*
 * Konfigurasi Database Multi-Tenant Desa & Diskominfo (Banggai Kepulauan)
 * Mengalihkan koneksi database secara dinamis per desa (Database-per-Tenant)
 * serta mengisolasi basis data mandiri untuk Diskominfo Command Center (opensid_diskominfo).
 */

defined('BASEPATH') || exit('No direct script access allowed');

$dbHost = getenv('DB_HOST') ?: 'db';
$dbUser = getenv('DB_USERNAME') ?: 'opensid_user';
$dbPass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';
$dbPort = (int) (getenv('DB_PORT') ?: 3306);

// 1. Konfigurasi Grup Default
$db['default']['hostname'] = $dbHost;
$db['default']['username'] = $dbUser;
$db['default']['password'] = $dbPass;
$db['default']['port']     = $dbPort;
$db['default']['dbcollat'] = 'utf8mb4_unicode_ci';
$db['default']['stricton'] = false;

// Basis data default (Desa Pilot: Bobu)
$defaultDb = getenv('DB_DATABASE') ?: 'opensid_bobu';
$db['default']['database'] = $defaultDb;

// 2. Konfigurasi Koneksi Khusus Diskominfo (Terisolasi dari desa)
$db['diskominfo'] = [
    'hostname' => $dbHost,
    'username' => $dbUser,
    'password' => $dbPass,
    'database' => 'opensid_diskominfo',
    'dbdriver' => 'mysqli',
    'port'     => $dbPort,
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
    'swap_pre' => '',
    'stricton' => false,
];

// -------------------------------------------------------------
// Pemeriksaan Konteks: Diskominfo vs Portal Desa
// -------------------------------------------------------------
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$httpHost   = strtolower($_SERVER['HTTP_HOST'] ?? '');

$isDiskominfo = str_contains($requestUri, 'diskominfo')
             || str_starts_with($httpHost, 'diskominfo.')
             || (isset($_GET['app']) && $_GET['app'] === 'diskominfo');

if ($isDiskominfo) {
    // ---------------------------------------------------------
    // RUTE DISKOMINFO COMMAND CENTER: Gunakan opensid_diskominfo
    // ---------------------------------------------------------
    $diskominfoDb = 'opensid_diskominfo';

    // Auto-create basis data opensid_diskominfo secara aman jika belum dibuat di MariaDB
    try {
        $testConn = @mysqli_init();
        if ($testConn && @mysqli_real_connect($testConn, $dbHost, $dbUser, $dbPass, '', $dbPort, null, 0)) {
            @mysqli_query($testConn, "CREATE DATABASE IF NOT EXISTS `{$diskominfoDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            @mysqli_close($testConn);
        }
    } catch (\Throwable $e) {}

    $db['default']['database'] = $diskominfoDb;
    $defaultDb = $diskominfoDb;

} else {
    // ---------------------------------------------------------
    // RUTE PORTAL DESA: Multi-Tenant Resolver (Database-per-Tenant)
    // ---------------------------------------------------------
    $tenantSlug = null;
    $rawHost = strtolower($_SERVER['HTTP_HOST'] ?? '');
    $cleanHost = explode(':', $rawHost)[0];

    // Pemetaan Domain Khusus Desa (Custom Domain Mapping Banggai Kepulauan)
    $domainMap = [
        'bobu-tinangkungselatan.desa.id' => 'bobu',
        'bobu.banggaikep.go.id'          => 'bobu',
        'bobu.desa.id'                   => 'bobu',
    ];

    if (isset($domainMap[$cleanHost])) {
        $tenantSlug = $domainMap[$cleanHost];
    } elseif (str_contains($cleanHost, 'bobu-tinangkungselatan') || str_contains($cleanHost, 'bobu.')) {
        $tenantSlug = 'bobu';
    } elseif (! empty($_GET['desa'])) {
        $tenantSlug = strtolower(trim((string) $_GET['desa']));
    } elseif (! empty($_GET['tenant'])) {
        $tenantSlug = strtolower(trim((string) $_GET['tenant']));
    } elseif (isset($_SERVER['HTTP_X_TENANT_ID'])) {
        $tenantSlug = strtolower(trim((string) $_SERVER['HTTP_X_TENANT_ID']));
    } elseif (! empty($cleanHost)) {
        $hostParts = explode('.', $cleanHost);
        // Pola 1: {desa}-{kecamatan}.desa.id -> ambil slug desa di depan strip
        if (str_ends_with($cleanHost, '.desa.id') && str_contains($hostParts[0], '-')) {
            $tenantSlug = explode('-', $hostParts[0])[0];
        }
        // Pola 2: Subdomain multi-tenant (contoh: mansamat.banggaikep.go.id -> 'mansamat')
        elseif (count($hostParts) >= 3 && ! in_array($hostParts[0], ['www', 'diskominfo', 'admin', 'api', 'localhost'])) {
            $tenantSlug = $hostParts[0];
        }
    }

    // 2. Reset slug jika user sengaja ingin membersihkan filter (?desa=clear)
    if ($tenantSlug === 'clear' || $tenantSlug === 'reset') {
        $tenantSlug = null;
        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION['active_tenant_slug']);
        }
        if (! headers_sent()) {
            @setcookie('active_tenant_slug', '', time() - 3600, '/');
        }
    }

    // 3. Cek Session atau Cookie jika navigasi internal (misal di admin panel /siteman desa)
    if (! $tenantSlug) {
        if (session_status() === PHP_SESSION_ACTIVE && ! empty($_SESSION['active_tenant_slug'])) {
            $tenantSlug = $_SESSION['active_tenant_slug'];
        } elseif (isset($_COOKIE['active_tenant_slug']) && ! empty($_COOKIE['active_tenant_slug'])) {
            $tenantSlug = $_COOKIE['active_tenant_slug'];
        }
    }

    // 4. Verifikasi dan Tentukan Database Target Desa
    if ($tenantSlug && $tenantSlug !== 'bobu' && $tenantSlug !== 'diskominfo') {
        $cleanSlug = preg_replace('/[^a-z0-9_]/', '', $tenantSlug);
        if (! empty($cleanSlug)) {
            $candidateDb = 'opensid_' . $cleanSlug;

            // Cek cepat apakah database benar-benar ada di MariaDB server
            // untuk mencegah MySQL Error 1049 jika desa belum dibuat via CLI
            $dbExists = false;
            try {
                $testConn = @mysqli_init();
                if ($testConn && @mysqli_real_connect($testConn, $dbHost, $dbUser, $dbPass, '', $dbPort, null, 0)) {
                    $dbExists = @mysqli_select_db($testConn, $candidateDb);
                    @mysqli_close($testConn);
                }
            } catch (\Throwable $e) {
                $dbExists = false;
            }

            if ($dbExists) {
                $db['default']['database'] = $candidateDb;
                if (session_status() === PHP_SESSION_ACTIVE) {
                    $_SESSION['active_tenant_slug'] = $cleanSlug;
                }
                if (! headers_sent()) {
                    @setcookie('active_tenant_slug', $cleanSlug, time() + (86400 * 30), '/');
                }
            } else {
                // Jika database desa belum dibuat, gunakan opensid_bobu secara aman
                $db['default']['database'] = $defaultDb;
                if (session_status() === PHP_SESSION_ACTIVE) {
                    unset($_SESSION['active_tenant_slug']);
                }
                if (! headers_sent()) {
                    @setcookie('active_tenant_slug', '', time() - 3600, '/');
                }
            }
        }
    } elseif ($tenantSlug === 'bobu') {
        $db['default']['database'] = 'opensid_bobu';
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['active_tenant_slug'] = 'bobu';
        }
        if (! headers_sent()) {
            @setcookie('active_tenant_slug', 'bobu', time() + (86400 * 30), '/');
        }
    }
}
