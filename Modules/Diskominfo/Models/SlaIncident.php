<?php

namespace Modules\Diskominfo\Models;

use Illuminate\Database\Eloquent\Model;

class SlaIncident extends Model
{
    protected $connection = 'diskominfo';

    protected $table = 'diskominfo_sla_incidents';

    protected $guarded = [];

    protected $casts = [
        'status_code'     => 'integer',
        'latency_ms'      => 'integer',
        'recorded_at'     => 'datetime',
    ];

    /**
     * Dapatkan daftar sampel insiden SLA untuk monitoring pimpinan jika database belum bermigrasi.
     */
    public static function getRecentIncidents(): array
    {
        return [
            [
                'id'            => 1,
                'nama_desa'     => 'Desa Bualemo',
                'vendor_name'   => 'Vendor Lokal CMS Custom',
                'incident_type' => 'High Latency (> 2.000ms)',
                'status_code'   => 200,
                'latency_ms'    => 2150,
                'message'       => 'Waktu respon server melebihi ambang batas toleransi SLA (Target: <500ms)',
                'recorded_at'   => date('Y-m-d H:i:s', strtotime('-25 minutes')),
                'severity'      => 'warning',
            ],
            [
                'id'            => 2,
                'nama_desa'     => 'Desa Paisumosoni',
                'vendor_name'   => 'CV Sintuvu Solusindo (cPanel Cloud)',
                'incident_type' => 'Server Temporary Unavailable',
                'status_code'   => 503,
                'latency_ms'    => 0,
                'message'       => 'Layanan cPanel hosting mengalami maintenance tak terjadwal selama 4 menit',
                'recorded_at'   => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'severity'      => 'danger',
            ],
            [
                'id'            => 3,
                'nama_desa'     => 'Desa Tataba',
                'vendor_name'   => 'PT Digides Media',
                'incident_type' => 'SSL Certificate Renewed',
                'status_code'   => 200,
                'latency_ms'    => 180,
                'message'       => 'Pembaruan sertifikat SSL berhasil dilakukan tanpa downtime',
                'recorded_at'   => date('Y-m-d H:i:s', strtotime('-5 hours')),
                'severity'      => 'info',
            ],
            [
                'id'            => 4,
                'nama_desa'     => 'Desa Salakan',
                'vendor_name'   => 'PT Digides Sulteng (VPS)',
                'incident_type' => 'Network Spike Resolved',
                'status_code'   => 200,
                'latency_ms'    => 115,
                'message'       => 'Lonjakan trafik permohonan surat berhasil ditangani sistem cache',
                'recorded_at'   => date('Y-m-d H:i:s', strtotime('-1 day')),
                'severity'      => 'success',
            ],
        ];
    }
}
