<?php

/*
 * Modul Diskominfo Command Center, Multi-Vendor Hub & SLA Monitoring
 * Kabupaten Banggai Kepulauan
 */

defined('BASEPATH') || exit('No direct script access allowed');

Route::group('diskominfo', ['namespace' => 'Diskominfo'], static function (): void {
    // 1. Dashboard Utama Command Center
    Route::get('/', 'DiskominfoController@index')->name('diskominfo.dashboard');
    Route::get('/dashboard', 'DiskominfoController@index')->name('diskominfo.dashboard.alt');
    Route::get('/metrics', 'DiskominfoController@metrics')->name('diskominfo.metrics');

    // 2. Pusat SLA & Vendor Scorecard Pimpinan
    Route::get('/sla', 'DiskominfoController@sla')->name('diskominfo.sla');
    Route::get('/sla/ping/{slug?}', 'DiskominfoController@ping')->name('diskominfo.sla.ping');
    Route::post('/sla/ping/{slug?}', 'DiskominfoController@ping')->name('diskominfo.sla.ping.post');

    // 3. Manajemen Multi-Vendor & Simpul Desa
    Route::get('/desa', 'DiskominfoController@desa')->name('diskominfo.tenants');
    Route::get('/desa/create', 'DiskominfoController@createDesa')->name('diskominfo.desa.create');
    Route::post('/desa/store', 'DiskominfoController@storeDesa')->name('diskominfo.desa.store');
    Route::get('/desa/{slug}', 'DiskominfoController@desa')->name('diskominfo.tenants.show');

    // 4. WebGIS Spasial Sebaran Server Desa
    Route::get('/gis', 'DiskominfoController@gis')->name('diskominfo.gis');

    // 5. Laporan Kepatuhan SLA Eksekutif untuk Pimpinan Daerah
    Route::get('/laporan', 'DiskominfoController@laporan')->name('diskominfo.laporan');

    // 6. Universal REST API Data Ingestion untuk Vendor Eksternal
    Route::post('/api/ingest', 'DiskominfoController@apiIngest')->name('diskominfo.api.ingest');
    Route::get('/api/status', 'DiskominfoController@apiStatus')->name('diskominfo.api.status');
});
