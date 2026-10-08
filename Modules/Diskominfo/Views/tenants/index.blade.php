@extends('diskominfo::layouts.master')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #fff;">
            <i class="fa-solid fa-network-wired" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
            Manajemen Desa & Multi-Vendor Kab. Banggai Kepulauan
        </h2>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="{{ site_url('diskominfo/desa/create') }}" class="btn-action btn-cyan" style="font-size: 0.85rem; padding: 0.45rem 1rem;">
                <i class="fa-solid fa-plus-circle"></i> Daftarkan Desa / Vendor Baru
            </a>
            <span class="badge-pill badge-cyan" style="font-size: 0.85rem; padding: 0.45rem 1rem;">
                Total: {{ count($tenants) }} Simpul
            </span>
        </div>
    </div>
    <p style="color: var(--text-muted); font-size: 0.92rem;">
        Pusat kendali dan integrasi seluruh website desa di Kabupaten Banggai Kepulauan baik SaaS Internal Diskominfo 
        maupun vendor eksternal (cPanel, Cloud VPS Mandiri, atau Custom CMS).
    </p>

    @if(!empty($_SESSION['flash_success']) || !empty($_GET['registered']))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 8px; padding: 0.9rem 1.25rem; margin-top: 1rem; display: flex; align-items: center; gap: 0.75rem; color: #6ee7b7;">
        <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
        <span>{{ $_SESSION['flash_success'] ?? ('Desa ' . htmlspecialchars($_GET['registered']) . ' berhasil didaftarkan ke Pusat Monitoring Diskominfo!') }}</span>
    </div>
    @php unset($_SESSION['flash_success']); @endphp
    @endif
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
                Domain Resmi: <a href="http://bobu-tinangkungselatan.desa.id:8090" target="_blank" style="color: var(--accent-cyan); font-weight: 700; text-decoration: none;">bobu-tinangkungselatan.desa.id</a> • 
                Kode Wilayah: <span style="font-family: 'JetBrains Mono', monospace; color: #fff;">{{ $pilotTenant->kode_desa }}</span> • 
                Basis Data: <span style="font-family: 'JetBrains Mono', monospace; color: var(--accent-cyan);">{{ $pilotTenant->db_name }}</span>
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="http://bobu-tinangkungselatan.desa.id:8090/index.php/siteman" target="_blank" class="btn-action btn-outline" style="border-color: rgba(0, 229, 255, 0.4);">
                <i class="fa-solid fa-user-shield"></i> Admin Desa Bobu
            </a>
            <a href="http://bobu-tinangkungselatan.desa.id:8090" target="_blank" class="btn-action btn-cyan">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Portal Domain Desa
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
                        <div style="display: flex; gap: 0.4rem; align-items: center;">
                            <a href="{{ base_url('index.php?desa=' . ($t->slug ?? $t['slug'] ?? 'bobu')) }}" target="_blank" class="btn-action btn-cyan" style="font-size: 0.72rem; padding: 0.3rem 0.6rem;">
                                Portal <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                            <a href="{{ base_url('index.php/siteman?desa=' . ($t->slug ?? $t['slug'] ?? 'bobu')) }}" target="_blank" class="btn-action btn-outline" style="font-size: 0.72rem; padding: 0.3rem 0.6rem;">
                                Admin <i class="fa-solid fa-user-shield"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Arsitektur Database-per-Tenant Info Card -->
<div class="glass-card" style="margin-top: 2rem; border-color: rgba(14, 165, 233, 0.3);">
    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
        <i class="fa-solid fa-database" style="color: var(--accent-cyan); font-size: 1.25rem;"></i>
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #fff; margin: 0;">
            Panduan Arsitektur Terisolasi (Database-per-Tenant)
        </h3>
    </div>
    <p style="color: var(--text-muted); font-size: 0.88rem; line-height: 1.6; margin-bottom: 1rem;">
        Setiap desa di Kabupaten Banggai Kepulauan memiliki basis data fisik MySQL terpisah (<code style="color: var(--accent-cyan);">opensid_{slug}</code>). 
        Untuk mendaftarkan dan membuat basis data mandiri bagi desa baru secara instan, jalankan perintah CLI berikut di terminal VPS:
    </p>
    <div style="background: rgba(0, 0, 0, 0.4); border-radius: 8px; padding: 1rem; border: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 0.75rem;">
        <div style="font-size: 0.75rem; color: var(--text-subtle); margin-bottom: 0.4rem;">Perintah Pembuatan Database & Portal Desa Baru:</div>
        <code style="color: #38bdf8; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; display: block; word-break: break-all;">
            docker exec opensid_staging_app php artisan opensid:provision-tenant mansamat --name="Mansamat" --kecamatan="Tinangkung Selatan"
        </code>
    </div>
    <div style="background: rgba(0, 0, 0, 0.4); border-radius: 8px; padding: 1rem; border: 1px solid rgba(255, 255, 255, 0.1);">
        <div style="font-size: 0.75rem; color: var(--text-subtle); margin-bottom: 0.4rem;">Perintah Sinkronisasi Statistik Kabupaten dari Seluruh Database Desa:</div>
        <code style="color: #10b981; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; display: block; word-break: break-all;">
            docker exec opensid_staging_app php artisan opensid:sync-metrics
        </code>
    </div>
</div>
@endsection
