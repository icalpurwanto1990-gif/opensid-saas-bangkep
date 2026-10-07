@extends('diskominfo::layouts.master')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #fff;">
            <i class="fa-solid fa-network-wired" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
            Manajemen Desa SaaS Kabupaten Banggai Kepulauan
        </h2>
        <span class="badge-pill badge-cyan" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
            Total Terdaftar: {{ count($tenants) }} Simpul
        </span>
    </div>
    <p style="color: var(--text-muted); font-size: 0.92rem;">
        Setiap desa di bawah ini beroperasi secara mandiri dengan isolasi basis data terpisah (Database-per-Tenant), 
        dan terpantau secara terpusat oleh Dinas Komunikasi dan Informatika.
    </p>
</div>

<!-- Pilot Village Special Card -->
<div class="glass-card" style="border-color: rgba(0, 229, 255, 0.4); margin-bottom: 2rem; background: linear-gradient(135deg, rgba(0, 229, 255, 0.08), rgba(17, 24, 39, 0.9));">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                <span class="badge-pill badge-emerald"><i class="fa-solid fa-star"></i> PILOT UTAMA AKTIF</span>
                <span class="badge-pill badge-cyan">Kecamatan Tinangkung Selatan</span>
            </div>
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem;">
                {{ $pilotTenant->nama_desa }}
            </h3>
            <p style="color: var(--text-muted); font-size: 0.85rem;">
                Kode Wilayah: <span style="font-family: 'JetBrains Mono', monospace; color: #fff;">{{ $pilotTenant->kode_desa }}</span> • 
                Kepala Desa: <strong>{{ $pilotTenant->nama_kepala_desa }}</strong> • 
                Basis Data: <span style="font-family: 'JetBrains Mono', monospace; color: var(--accent-cyan);">{{ $pilotTenant->db_name }}</span>
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ site_url('diskominfo/gis') }}" class="btn-action btn-outline">
                <i class="fa-solid fa-map-location-dot"></i> Koordinat Peta
            </a>
            <a href="{{ base_url('index.php?desa=bobu') }}" target="_blank" class="btn-action btn-cyan">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Luncurkan Sistem Desa Bobu
            </a>
        </div>
    </div>
</div>

<!-- Tenants List Table -->
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #fff;">
            Daftar Seluruh Simpul Desa (Tenants)
        </h3>
        <div style="font-size: 0.8rem; color: var(--text-subtle);">
            Status Sinkronisasi Real-Time
        </div>
    </div>

    <div class="table-container">
        <table class="custom-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">Nama Desa</th>
                    <th style="padding: 1rem;">Kecamatan</th>
                    <th style="padding: 1rem;">Domain / Subdomain</th>
                    <th style="padding: 1rem;">Total Penduduk</th>
                    <th style="padding: 1rem;">Koneksi DB</th>
                    <th style="padding: 1rem;">Terakhir Sinkron</th>
                    <th style="padding: 1rem;">Status</th>
                    <th style="padding: 1rem;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenants as $t)
                <tr>
                    <td style="padding: 1rem;">
                        <strong style="color: #fff; font-size: 0.95rem;">{{ $t->nama_desa }}</strong>
                        @if($t->slug === 'bobu')
                            <span class="badge-pill badge-cyan" style="font-size: 0.65rem; margin-left: 0.3rem;">PILOT</span>
                        @endif
                        <div style="font-size: 0.75rem; color: var(--text-subtle);">Kades: {{ $t->nama_kepala_desa }}</div>
                    </td>
                    <td style="padding: 1rem;">{{ $t->kecamatan }}</td>
                    <td style="padding: 1rem;">
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--accent-cyan);">
                            {{ $t->subdomain }}
                        </span>
                        <div style="font-size: 0.72rem; color: var(--text-subtle);">{{ $t->custom_domain }}</div>
                    </td>
                    <td style="padding: 1rem;">
                        <strong>{{ number_format($t->total_penduduk, 0, ',', '.') }}</strong> Jiwa
                        <div style="font-size: 0.72rem; color: var(--text-subtle);">{{ $t->total_kk }} KK</div>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge-pill badge-blue" style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem;">
                            {{ $t->db_name }}
                        </span>
                    </td>
                    <td style="padding: 1rem; font-size: 0.8rem; color: var(--text-muted);">
                        {{ $t->terakhir_sync }}
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge-pill badge-emerald">
                            <span class="pulse-dot"></span> {{ $t->status }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <a href="{{ base_url('index.php?desa=' . ($t->slug ?? $t['slug'] ?? 'bobu')) }}" target="_blank" class="btn-action btn-cyan" style="font-size: 0.75rem; padding: 0.35rem 0.75rem;">
                            Buka Portal <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
