@extends('diskominfo::layouts.master')

@section('styles')
<style>
    .hero-banner {
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.15), rgba(0, 229, 255, 0.05));
        border: 1px solid rgba(0, 229, 255, 0.2);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        right: -60px;
        top: -60px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(0, 229, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-content h2 {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .hero-content p {
        color: var(--text-muted);
        font-size: 0.95rem;
        max-width: 650px;
        line-height: 1.5;
    }

    .pilot-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(0, 229, 255, 0.15);
        color: var(--accent-cyan);
        border: 1px solid rgba(0, 229, 255, 0.35);
        padding: 0.35rem 0.9rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    /* KPI Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.4rem;
        position: relative;
        overflow: hidden;
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--card-accent, var(--accent-blue));
    }

    .kpi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
    }

    .kpi-title {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .kpi-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.05);
        color: var(--card-accent, var(--accent-blue));
    }

    .kpi-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: #fff;
        font-family: 'JetBrains Mono', monospace;
        letter-spacing: -0.03em;
        margin-bottom: 0.4rem;
    }

    .kpi-subtext {
        font-size: 0.75rem;
        color: var(--text-subtle);
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Dashboard Main Layout */
    .dashboard-split {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
        .dashboard-split {
            grid-template-columns: 1fr;
        }
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .custom-table th {
        text-align: left;
        padding: 0.85rem 1rem;
        color: var(--text-subtle);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        color: var(--text-main);
    }

    .custom-table tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .village-name {
        font-weight: 700;
        color: #fff;
        display: block;
    }

    .village-sub {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Progress bars */
    .progress-bar-bg {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 4px;
        overflow: hidden;
        margin-top: 0.4rem;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #0284c7, #00e5ff);
    }
</style>
@endsection

@section('content')

    <!-- Hero Banner Pilot Information -->
    <div class="hero-banner">
        <div class="hero-content">
            <div class="pilot-tag">
                <i class="fa-solid fa-flag-checkered"></i> PILOT PROJECT AKTIF: DESA BOBU
            </div>
            <h2>Pusat Komando & Integrasi SaaS Desa Digital</h2>
            <p>
                Sistem Terpadu Dinas Komunikasi dan Informatika Kabupaten Banggai Kepulauan memantau 
                dan mengelola infrastruktur administrasi desa, tata kelola kependudukan, transparansi anggaran, 
                serta percepatan pelayanan masyarakat se-kabupaten.
            </p>
        </div>
        <div style="text-align: right; z-index: 1;">
            <div style="font-size: 0.8rem; color: var(--text-subtle); margin-bottom: 0.3rem;">Kecamatan Pilot</div>
            <div style="font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 0.8rem;">Tinangkung Selatan</div>
            <a href="{{ site_url('index.php?desa=bobu') }}" target="_blank" class="btn-action btn-cyan">
                <i class="fa-solid fa-desktop"></i> Akses Portal Desa Bobu
            </a>
        </div>
    </div>

    <!-- KPI Metric Summary -->
    <div class="kpi-grid">
        <div class="kpi-card" style="--card-accent: var(--accent-cyan);">
            <div class="kpi-header">
                <span class="kpi-title">Desa Terhubung SaaS</span>
                <div class="kpi-icon"><i class="fa-solid fa-sitemap"></i></div>
            </div>
            <div class="kpi-value">{{ $summary['desa_terhubung'] }} <span style="font-size: 0.95rem; color: var(--text-subtle); font-weight: 500;">/ {{ $summary['total_desa'] }}</span></div>
            <div class="kpi-subtext">
                <i class="fa-solid fa-circle-check text-green" style="color: var(--accent-emerald);"></i> 100% Online & Terisolasi
            </div>
        </div>

        <div class="kpi-card" style="--card-accent: var(--accent-blue);">
            <div class="kpi-header">
                <span class="kpi-title">Penduduk Teragregasi</span>
                <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($summary['total_penduduk'], 0, ',', '.') }}</div>
            <div class="kpi-subtext">
                <i class="fa-solid fa-arrow-trend-up" style="color: var(--accent-cyan);"></i> {{ number_format($summary['total_kk'], 0, ',', '.') }} Kepala Keluarga
            </div>
        </div>

        <div class="kpi-card" style="--card-accent: var(--accent-emerald);">
            <div class="kpi-header">
                <span class="kpi-title">Surat Digital Terbit</span>
                <div class="kpi-icon"><i class="fa-solid fa-file-signature"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($summary['total_surat_terbit'], 0, ',', '.') }}</div>
            <div class="kpi-subtext">
                <i class="fa-solid fa-stamp" style="color: var(--accent-emerald);"></i> Adopsi TTE: {{ $summary['persentase_tte'] }}
            </div>
        </div>

        <div class="kpi-card" style="--card-accent: var(--accent-amber);">
            <div class="kpi-header">
                <span class="kpi-title">Bansos Tersalurkan</span>
                <div class="kpi-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
            </div>
            <div class="kpi-value">{{ number_format($summary['total_bansos_tersalur'], 0, ',', '.') }}</div>
            <div class="kpi-subtext">
                <i class="fa-solid fa-shield-halved" style="color: var(--accent-amber);"></i> Sinkronisasi DTKS Terverifikasi
            </div>
        </div>
    </div>

    <!-- Main Dashboard Split -->
    <div class="dashboard-split">
        <!-- Left Column: Pilot Village Overview & Registered Villages -->
        <div class="glass-card">
            <div class="section-title">
                <span><i class="fa-solid fa-satellite-dish" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i> Status Simpul Desa Terintegrasi (Banggai Kepulauan)</span>
                <a href="{{ site_url('diskominfo/desa') }}" class="btn-action btn-outline" style="font-size: 0.78rem; padding: 0.35rem 0.8rem;">
                    Lihat Semua Desa
                </a>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Desa / Kecamatan</th>
                            <th>Kode Wilayah</th>
                            <th>Subdomain SaaS</th>
                            <th>Populasi</th>
                            <th>Status Node</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $t)
                        <tr>
                            <td>
                                <span class="village-name">{{ $t->nama_desa }}</span>
                                <span class="village-sub">Kec. {{ $t->kecamatan }}</span>
                            </td>
                            <td>
                                <span style="font-family: 'JetBrains Mono', monospace; color: var(--text-muted);">{{ $t->kode_desa }}</span>
                            </td>
                            <td>
                                <span class="badge-pill badge-cyan" style="font-family: 'JetBrains Mono', monospace;">
                                    {{ $t->subdomain }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ number_format($t->total_penduduk, 0, ',', '.') }}</strong> Jiwa
                                <div style="font-size: 0.7rem; color: var(--text-subtle);">{{ $t->total_kk }} KK</div>
                            </td>
                            <td>
                                <span class="badge-pill badge-emerald">
                                    <span class="pulse-dot"></span> Online
                                </span>
                            </td>
                            <td>
                                <a href="{{ site_url('index.php?desa=' . $t->slug) }}" target="_blank" class="btn-action btn-outline" style="font-size: 0.75rem; padding: 0.3rem 0.65rem;">
                                    Buka <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Detail Pilot Desa Bobu -->
        <div class="glass-card" style="border-color: rgba(0, 229, 255, 0.3);">
            <div class="section-title">
                <span><i class="fa-solid fa-award" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i> Profil Pilot: Desa Bobu</span>
                <span class="badge-pill badge-emerald">Terverifikasi</span>
            </div>

            <div style="margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-color);">
                <div style="font-size: 0.8rem; color: var(--text-subtle); margin-bottom: 0.2rem;">Kepala Desa</div>
                <div style="font-size: 1.05rem; font-weight: 700; color: #fff;">{{ $pilotTenant->nama_kepala_desa }}</div>
                <div style="font-size: 0.78rem; color: var(--accent-cyan); margin-top: 0.2rem;">
                    Kec. Tinangkung Selatan • Kab. Banggai Kepulauan
                </div>
            </div>

            <!-- Demography Breakdown -->
            <div style="margin-bottom: 1.25rem;">
                <div style="font-size: 0.82rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.6rem;">
                    Distribusi Gender Desa Bobu (1.428 Jiwa)
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.2rem;">
                    <span>Laki-Laki: 742</span>
                    <span>Perempuan: 686</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: 52%;"></div>
                </div>
            </div>

            <!-- Social Assistance -->
            <div style="margin-bottom: 1.5rem;">
                <div style="font-size: 0.82rem; font-weight: 600; color: var(--text-muted); margin-bottom: 0.6rem;">
                    Penerima Bantuan Sosial di Bobu
                </div>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <span class="badge-pill badge-blue">BLT-DD: 112 KPM</span>
                    <span class="badge-pill badge-amber">PKH: 84 KPM</span>
                    <span class="badge-pill badge-emerald">BPNT: 96 KPM</span>
                </div>
            </div>

            <!-- Action buttons -->
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ site_url('diskominfo/gis') }}" class="btn-action btn-outline" style="justify-content: center;">
                    <i class="fa-solid fa-map"></i> Buka Peta Spasial Desa Bobu
                </a>
                <a href="{{ site_url('index.php?desa=bobu') }}" target="_blank" class="btn-action btn-cyan" style="justify-content: center;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk ke Sistem Desa Bobu
                </a>
            </div>
        </div>
    </div>

@endsection
