<?php

namespace Modules\Diskominfo\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $connection = 'diskominfo';

    protected $table = 'diskominfo_tenants';

    protected $guarded = [];

    protected $casts = [
        'lat'              => 'float',
        'lng'              => 'float',
        'total_penduduk'   => 'integer',
        'total_kk'         => 'integer',
        'total_surat'      => 'integer',
        'apbdes_total'     => 'float',
        'apbdes_realisasi' => 'float',
        'bansos_tersalurkan' => 'integer',
        'sla_target'       => 'float',
        'uptime_pct'       => 'float',
        'latency_ms'       => 'integer',
    ];

    /**
     * Dapatkan URL desa aktif.
     */
    public function getUrlAttribute(): string
    {
        if (! empty($this->url_portal)) {
            return $this->url_portal;
        }

        if (! empty($this->custom_domain)) {
            return 'http://' . $this->custom_domain;
        }

        if (! empty($this->subdomain)) {
            return 'http://' . $this->subdomain;
        }

        return base_url('index.php?desa=' . $this->slug);
    }

    /**
     * URL lokal untuk pengujian langsung tanpa DNS khusus.
     */
    public function getLocalUrlAttribute(): string
    {
        return base_url('index.php?desa=' . $this->slug);
    }

    /**
     * Label tipe server / vendor.
     */
    public function getServerTypeLabelAttribute(): string
    {
        return match ($this->tipe_server ?? 'internal_saas') {
            'internal_saas'    => 'Diskominfo SaaS Cloud',
            'external_hosting' => 'Hosting Vendor Eksternal',
            'external_vps'     => 'VPS Mandiri Vendor',
            'third_party_cms'  => 'CMS Pihak Ketiga (Custom)',
            default            => 'Infrastruktur Mandiri',
        };
    }

    /**
     * Badge CSS class untuk tipe server.
     */
    public function getServerTypeBadgeAttribute(): string
    {
        return match ($this->tipe_server ?? 'internal_saas') {
            'internal_saas'    => 'badge-cyan',
            'external_hosting' => 'badge-blue',
            'external_vps'     => 'badge-purple',
            'third_party_cms'  => 'badge-yellow',
            default            => 'badge-cyan',
        };
    }

    /**
     * Badge CSS class untuk SLA keandalan.
     */
    public function getSlaBadgeClassAttribute(): string
    {
        $uptime = (float) ($this->uptime_pct ?? 99.0);
        if ($uptime >= 99.0) {
            return 'badge-emerald';
        }
        if ($uptime >= 95.0) {
            return 'badge-yellow';
        }
        return 'badge-red';
    }

    /**
     * Badge status kesehatan server terkini.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        $status = strtolower($this->last_status ?? 'online');
        return match ($status) {
            'online'   => 'badge-emerald',
            'degraded' => 'badge-yellow',
            'offline'  => 'badge-red',
            default    => 'badge-emerald',
        };
    }
}
