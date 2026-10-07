<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * Routes untuk Diskominfo Command Center & SaaS Multi-Tenant
 * Kabupaten Banggai Kepulauan
 */

Route::get('diskominfo', 'Diskominfo@index')->name('diskominfo.index');

Route::group('diskominfo', static function (): void {
    Route::get('/', 'Diskominfo@index')->name('diskominfo.dashboard');
    Route::get('dashboard', 'Diskominfo@index')->name('diskominfo.dashboard.alt');
    Route::get('metrics', 'Diskominfo@metrics')->name('diskominfo.metrics');

    // Manajemen Monitoring Desa (Tenants)
    Route::get('desa', 'Diskominfo@desa')->name('diskominfo.tenants');
    Route::get('desa/{slug}', 'Diskominfo@desa')->name('diskominfo.tenants.show');

    // WebGIS Spasial Kabupaten Banggai Kepulauan
    Route::get('gis', 'Diskominfo@gis')->name('diskominfo.gis');
});
