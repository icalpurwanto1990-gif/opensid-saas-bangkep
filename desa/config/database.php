<?php

/*
 * Konfigurasi Database Multi-Tenant Desa (Banggai Kepulauan)
 * Mengalihkan koneksi database secara dinamis per desa (Database-per-Tenant)
 */

defined('BASEPATH') || exit('No direct script access allowed');

$db['default']['hostname'] = getenv('DB_HOST') ?: 'db';
$db['default']['username'] = getenv('DB_USERNAME') ?: 'opensid_user';
$db['default']['password'] = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';
$db['default']['port']     = (int) (getenv('DB_PORT') ?: 3306);
$db['default']['dbcollat'] = 'utf8mb4_general_ci';
$db['default']['stricton'] = false;

// Basis data default (Desa Pilot: Bobu)
$defaultDb = getenv('DB_DATABASE') ?: 'opensid_bobu';
$db['default']['database'] = $defaultDb;

// -------------------------------------------------------------
// Multi-Tenant Dynamic Database Resolver (Banggai Kepulauan)
// -------------------------------------------------------------
$tenantSlug = null;

// 1. Cek parameter URL (?desa=... atau ?tenant=...)
if (! empty($_GET['desa'])) {
    $tenantSlug = strtolower(trim((string) $_GET['desa']));
} elseif (! empty($_GET['tenant'])) {
    $tenantSlug = strtolower(trim((string) $_GET['tenant']));
} elseif (isset($_SERVER['HTTP_X_TENANT_ID'])) {
    $tenantSlug = strtolower(trim((string) $_SERVER['HTTP_X_TENANT_ID']));
} elseif (isset($_SERVER['HTTP_HOST'])) {
    $host = strtolower($_SERVER['HTTP_HOST']);
    $hostParts = explode('.', $host);
    // Jika subdomain (contoh: bobu.banggaikep.go.id -> 'bobu')
    if (count($hostParts) >= 3 && ! in_array($hostParts[0], ['www', 'diskominfo', 'admin', 'api', 'localhost'])) {
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

// 3. Cek Session atau Cookie jika navigasi internal (misal di admin panel /siteman)
if (! $tenantSlug) {
    if (session_status() === PHP_SESSION_ACTIVE && ! empty($_SESSION['active_tenant_slug'])) {
        $tenantSlug = $_SESSION['active_tenant_slug'];
    } elseif (isset($_COOKIE['active_tenant_slug']) && ! empty($_COOKIE['active_tenant_slug'])) {
        $tenantSlug = $_COOKIE['active_tenant_slug'];
    }
}

// 4. Verifikasi dan Tentukan Database Target
if ($tenantSlug && $tenantSlug !== 'bobu') {
    $cleanSlug = preg_replace('/[^a-z0-9_]/', '', $tenantSlug);
    if (! empty($cleanSlug)) {
        $candidateDb = 'opensid_' . $cleanSlug;

        // Cek cepat apakah database benar-benar ada di MariaDB server
        // untuk mencegah MySQL Error 1049 jika desa belum dibuat via CLI
        $dbExists = false;
        try {
            $testConn = @mysqli_init();
            if ($testConn && @mysqli_real_connect($testConn, $db['default']['hostname'], $db['default']['username'], $db['default']['password'], '', $db['default']['port'], null, 0)) {
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
            // Jika database belum dibuat, tetap gunakan default database (opensid_bobu) tanpa error
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
