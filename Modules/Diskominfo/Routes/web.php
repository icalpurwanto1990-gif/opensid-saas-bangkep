<?php

/*
 * Modul Diskominfo Command Center & SaaS Multi-Tenant
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

Route::group('diskominfo', static function (): void {
    // Dashboard Utama Command Center
    Route::get('/', 'Diskominfo@index')->name('diskominfo.dashboard');
    Route::get('/dashboard', 'Diskominfo@index')->name('diskominfo.dashboard.alt');
    Route::get('/metrics', 'Diskominfo@metrics')->name('diskominfo.metrics');

    // Manajemen Monitoring Desa (Tenants)
    Route::get('/desa', 'Diskominfo@desa')->name('diskominfo.tenants');
    Route::get('/desa/{slug}', 'Diskominfo@desa')->name('diskominfo.tenants.show');

    // WebGIS Spasial Kabupaten Banggai Kepulauan
    Route::get('/gis', 'Diskominfo@gis')->name('diskominfo.gis');
});
