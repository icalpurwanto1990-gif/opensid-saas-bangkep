<?php

/*
 * Konfigurasi Khusus Diskominfo Command Center & SLA Hub (Laravel Components)
 * Pemerintah Kabupaten Banggai Kepulauan
 */

return [
    'app_name'           => 'Pusat Komando & Pengawasan SLA SPBE Desa',
    'app_abbr'           => 'Diskominfo Bangkep Hub',
    'kabupaten'          => 'Kabupaten Banggai Kepulauan',
    'provinsi'           => 'Sulawesi Tengah',
    'instansi'           => 'Dinas Komunikasi dan Informatika',
    'email_resmi'        => 'diskominfo@banggaikep.go.id',

    // Basis Data Khusus (Terisolasi dari basis data desa)
    'database'           => 'opensid_diskominfo',
    'db_connection'      => 'diskominfo',

    // Sesi & Hak Akses Terpisah
    'session_key'        => 'diskominfo_authenticated_user',
    'session_role_key'   => 'diskominfo_user_role',

    // Default Super Admin
    'default_admin'      => [
        'username' => 'admin_diskominfo',
        'nama'     => 'Administrator Diskominfo Bangkep',
        'email'    => 'admin.diskominfo@banggaikep.go.id',
        'role'     => 'superadmin',
    ],

    // SLA Monitoring Settings
    'sla_default_target' => 99.00,
    'ping_timeout_sec'   => 4,
    'api_token_header'   => 'X-Diskominfo-Token',
    'api_master_token'   => 'KAB_BANGKEP_SECURE_TOKEN_2026',
];
