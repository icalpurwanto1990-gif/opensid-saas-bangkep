<?php

/*
 * Modul Diskominfo Command Center & SaaS Multi-Tenant
 * Kabupaten Banggai Kepulauan
 *
 * PENTING: namespace 'Diskominfo' wajib ada. Tanpa namespace, target rute menjadi
 * 'Diskominfo/index' dan HMVC router akan mencari Modules/Diskominfo/Http/Controllers/Index.php
 * (tidak ada) sehingga menghasilkan 404.
 */

defined('BASEPATH') || exit('No direct script access allowed');

Route::group('diskominfo', ['namespace' => 'Diskominfo'], static function (): void {
    // Dashboard Utama Command Center
    Route::get('/', 'DiskominfoController@index')->name('diskominfo.dashboard');
    Route::get('/dashboard', 'DiskominfoController@index')->name('diskominfo.dashboard.alt');
    Route::get('/metrics', 'DiskominfoController@metrics')->name('diskominfo.metrics');

    // Manajemen Monitoring Desa (Tenants)
    Route::get('/desa', 'DiskominfoController@desa')->name('diskominfo.tenants');
    Route::get('/desa/{slug}', 'DiskominfoController@desa')->name('diskominfo.tenants.show');

    // WebGIS Spasial Kabupaten Banggai Kepulauan
    Route::get('/gis', 'DiskominfoController@gis')->name('diskominfo.gis');
});
