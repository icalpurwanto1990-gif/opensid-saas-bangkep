<?php

defined('BASEPATH') || exit('No direct script access allowed');

$config['nama_desa']      = 'Desa Bobu';
$config['kode_desa']      = '72.07.03.2001';
$config['kecamatan']      = 'Tinangkung Selatan';
$config['kabupaten']      = 'Banggai Kepulauan';
$config['provinsi']       = 'Sulawesi Tengah';
$config['kode_pos']       = '94785';
$config['demo_mode']      = false;

// Pengecualian CSRF untuk rute Web Admin Diskominfo & Universal API Ingestion
$config['csrf_exclude_uris'] = [
    'api.*+',
    'external_api.*+',
    'internal_api.*+',
    'playwright.*+',
    'pelanggan/pemesanan',
    'diskominfo/login',
    'diskominfo/logout',
    'diskominfo/api.*+',
    'diskominfo/api/ingest',
    'diskominfo/desa/store',
    'diskominfo/sla/ping.*+',
];
