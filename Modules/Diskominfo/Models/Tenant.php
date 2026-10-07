<?php

namespace Modules\Diskominfo\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';

    protected $guarded = [];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'total_penduduk' => 'integer',
        'total_kk' => 'integer',
        'total_surat' => 'integer',
        'apbdes_total' => 'float',
        'apbdes_realisasi' => 'float',
    ];

    /**
     * Dapatkan URL desa aktif.
     */
    public function getUrlAttribute(): string
    {
        if (! empty($this->custom_domain)) {
            return 'http://' . $this->custom_domain;
        }

        if (! empty($this->subdomain)) {
            return 'http://' . $this->subdomain;
        }

        return url('/?desa=' . $this->slug);
    }

    /**
     * URL lokal untuk pengujian langsung tanpa DNS khusus.
     */
    public function getLocalUrlAttribute(): string
    {
        return url('/?desa=' . $this->slug);
    }
}
