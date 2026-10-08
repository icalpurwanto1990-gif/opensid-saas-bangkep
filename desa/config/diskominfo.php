<?php

/*
 * Konfigurasi Khusus Diskominfo Command Center & SLA Hub
 * Pemerintah Kabupaten Banggai Kepulauan
 *
 * Konfigurasi ini terpisah secara independen dari konfigurasi desa OpenSID.
 */

defined('BASEPATH') || exit('No direct script access allowed');

$config['diskominfo'] = [
    // Identitas Aplikasi Pusat
    'app_name'           => 'Pusat Komando & Pengawasan SLA SPBE Desa',
    'app_abbr'           => 'Diskominfo Bangkep Hub',
    'kabupaten'          => 'Kabupaten Banggai Kepulauan',
    'provinsi'           => 'Sulawesi Tengah',
    'instansi'           => 'Dinas Komunikasi dan Informatika',
    'alamat'             => 'Jalan Bukit Halimun, Salakan, Kab. Banggai Kepulauan',
    'email_resmi'        => 'diskominfo@banggaikep.go.id',

    // Basis Data Khusus (Terisolasi dari basis data desa)
    'database'           => 'opensid_diskominfo',
    'db_connection'      => 'diskominfo',

    // Kunci Sesi & Hak Akses Terpisah (Bukan sesi siteman desa)
    'session_key'        => 'diskominfo_authenticated_user',
    'session_role_key'   => 'diskominfo_user_role',
    'session_lifetime'   => 86400, // 24 jam

    // Kredensial Default Super Admin Diskominfo
    'default_admin'      => [
        'username' => 'admin_diskominfo',
        'nama'     => 'Administrator Diskominfo Bangkep',
        'email'    => 'admin.diskominfo@banggaikep.go.id',
        'role'     => 'superadmin',
    ],

    // Daftar Peran (Roles) Khusus Web Admin Diskominfo
    'roles'              => [
        'superadmin'      => 'Super Administrator Diskominfo',
        'operator_sla'    => 'Operator Monitoring Jaringan & SLA',
        'pimpinan_daerah' => 'Pimpinan Daerah (Bupati / Sekda / Kadis)',
    ],

    // Konfigurasi Audit & SLA Monitoring
    'sla_default_target' => 99.00,
    'ping_timeout_sec'   => 4,
    'api_token_header'   => 'X-Diskominfo-Token',
    'api_master_token'   => 'KAB_BANGKEP_SECURE_TOKEN_2026',
];
