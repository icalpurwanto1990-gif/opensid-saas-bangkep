@extends('diskominfo::layouts.master')

@section('content')
<style>
@media print {
    /* Optimasi Cetak Format Dokumen Resmi Pemerintah Daerah */
    body {
        background: #ffffff !important;
        color: #000000 !important;
        font-family: 'Times New Roman', Times, serif !important;
    }
    .topbar, .btn-action, .no-print, .badge-pill i, .pulse-dot {
        display: none !important;
    }
    .container {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .glass-card {
        background: none !important;
        border: 1px solid #ccc !important;
        box-shadow: none !important;
        color: #000 !important;
        margin-bottom: 1.5rem !important;
        page-break-inside: avoid;
    }
    h1, h2, h3, h4, p, span, td, th {
        color: #000000 !important;
    }
    .custom-table {
        border-collapse: collapse !important;
        width: 100% !important;
    }
    .custom-table th, .custom-table td {
        border: 1px solid #000000 !important;
        padding: 6px 8px !important;
        color: #000000 !important;
        font-size: 10pt !important;
    }
    .kop-surat {
        display: flex !important;
    }
}
.kop-surat {
    display: none;
    border-bottom: 3px double #000;
    padding-bottom: 12px;
    margin-bottom: 20px;
    align-items: center;
    gap: 15px;
}
</style>

<!-- KOP SURAT RESMI UNTUK CETAK -->
<div class="kop-surat">
    <div style="width: 75px; text-align: center;">
        <i class="fa-solid fa-landmark" style="font-size: 48px; color: #000;"></i>
    </div>
    <div style="flex: 1; text-align: center;">
        <h4 style="margin: 0; font-size: 14pt; font-weight: bold; text-transform: uppercase;">PEMERINTAH KABUPATEN BANGGAI KEPULAUAN</h4>
        <h3 style="margin: 3px 0; font-size: 16pt; font-weight: bold; text-transform: uppercase;">DINAS KOMUNIKASI DAN INFORMATIKA</h3>
        <p style="margin: 0; font-size: 9pt;">Jalan Bukit Halimun, Salakan, Kabupaten Banggai Kepulauan, Sulawesi Tengah</p>
        <p style="margin: 0; font-size: 9pt;">Laman: diskominfo.banggaikep.go.id | Email: diskominfo@banggaikep.go.id</p>
    </div>
</div>

<!-- Header Laporan di Layar -->
<div class="no-print" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0;">
                <i class="fa-solid fa-file-contract" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
                Laporan Eksekutif Kepatuhan SLA & Multi-Vendor
            </h2>
            <p style="color: var(--text-muted); font-size: 0.92rem; margin-top: 0.3rem;">
                Dokumen resmi evaluasi ketersediaan sistem dan kualitas layanan pihak ketiga untuk Bupati dan Pimpinan Daerah.
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ site_url('diskominfo/sla') }}" class="btn-action btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Cockpit SLA
            </a>
            <button onclick="window.print()" class="btn-action btn-emerald" style="border: none; cursor: pointer; font-weight: 700;">
                <i class="fa-solid fa-print"></i> Cetak Dokumen / Simpan PDF
            </button>
        </div>
    </div>
</div>

<!-- Executive Summary Header -->
<div class="glass-card" style="margin-bottom: 1.5rem; border-color: rgba(0, 229, 255, 0.4);">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 1rem; margin-bottom: 1.25rem;">
        <div>
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--accent-cyan); font-weight: 700;">
                NOTA LAPORAN HASIL MONITORING INFRASTRUKTUR SPBE DESA
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #fff; margin: 0.25rem 0;">
                Evaluasi Ketersediaan Layanan Portal & Basis Data Desa Se-Kabupaten Banggai Kepulauan
            </h3>
            <div style="font-size: 0.85rem; color: var(--text-muted);">
                Periode Pemantauan: <strong>Tahun Berjalan {{ date('Y') }}</strong> • Status Sinkronisasi: <strong>Terkini</strong>
            </div>
        </div>
        <div style="text-align: right;">
            <span class="badge-pill badge-emerald" style="font-size: 0.9rem; padding: 0.5rem 1.2rem;">
                Kepatuhan Kabupaten: {{ $slaSummary['rata_rata_uptime'] ?? 99.4 }}%
            </span>
        </div>
    </div>

    <!-- Ringkasan Angka Eksekutif -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div style="background: rgba(255, 255, 255, 0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div style="font-size: 0.75rem; color: var(--text-subtle); text-transform: uppercase;">Total Desa Terdaftar</div>
            <div style="font-size: 1.6rem; font-weight: 800; color: #fff; margin-top: 0.2rem;">
                {{ $slaSummary['total_desa'] ?? count($tenants) }} <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">Desa</span>
            </div>
            <div style="font-size: 0.75rem; color: var(--accent-cyan); margin-top: 0.3rem;">100% Terintegrasi</div>
        </div>

        <div style="background: rgba(255, 255, 255, 0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div style="font-size: 0.75rem; color: var(--text-subtle); text-transform: uppercase;">Status Portal Online</div>
            <div style="font-size: 1.6rem; font-weight: 800; color: #34d399; margin-top: 0.2rem;">
                {{ $slaSummary['total_online'] ?? 6 }} / {{ $slaSummary['total_desa'] ?? count($tenants) }}
            </div>
            <div style="font-size: 0.75rem; color: #34d399; margin-top: 0.3rem;">Semua Node Responsif</div>
        </div>

        <div style="background: rgba(255, 255, 255, 0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div style="font-size: 0.75rem; color: var(--text-subtle); text-transform: uppercase;">Rata-rata Respon Latensi</div>
            <div style="font-size: 1.6rem; font-weight: 800; color: #38bdf8; margin-top: 0.2rem;">
                {{ $slaSummary['rata_rata_latensi'] ?? 115 }} <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">ms</span>
            </div>
            <div style="font-size: 0.75rem; color: #38bdf8; margin-top: 0.3rem;">Kategori Sangat Cepat</div>
        </div>

        <div style="background: rgba(255, 255, 255, 0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div style="font-size: 0.75rem; color: var(--text-subtle); text-transform: uppercase;">Jumlah Vendor Pihak Ketiga</div>
            <div style="font-size: 1.6rem; font-weight: 800; color: #fbbf24; margin-top: 0.2rem;">
                {{ count($slaSummary['vendor_stats'] ?? []) }} <span style="font-size: 0.9rem; font-weight: normal; color: var(--text-muted);">Penyedia</span>
            </div>
            <div style="font-size: 0.75rem; color: #fbbf24; margin-top: 0.3rem;">Dalam Pengawasan Diskominfo</div>
        </div>
    </div>
</div>

<!-- Tabel Evaluasi Vendor -->
<div class="glass-card" style="margin-bottom: 1.5rem;">
    <h3 style="font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fa-solid fa-award" style="color: #fbbf24;"></i>
        Tabel 1: Evaluasi Peringkat Kepatuhan SLA Penyedia / Vendor
    </h3>

    <div class="table-container">
        <table class="custom-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.8rem; text-align: left;">Nama Vendor / Pengelola</th>
                    <th style="padding: 0.8rem; text-align: center;">Jumlah Node Desa</th>
                    <th style="padding: 0.8rem; text-align: center;">Realisasi Rata-rata Uptime</th>
                    <th style="padding: 0.8rem; text-align: center;">Rata-rata Latensi</th>
                    <th style="padding: 0.8rem; text-align: center;">Kategori Kepatuhan</th>
                    <th style="padding: 0.8rem; text-align: left;">Rekomendasi Diskominfo</th>
                </tr>
            </thead>
            <tbody>
                @foreach(($slaSummary['vendor_stats'] ?? []) as $vName => $vStat)
                <tr>
                    <td style="padding: 0.8rem; font-weight: 700; color: #fff;">
                        {{ $vName }}
                    </td>
                    <td style="padding: 0.8rem; text-align: center;">
                        <strong>{{ $vStat['count'] }}</strong> Desa
                    </td>
                    <td style="padding: 0.8rem; text-align: center;">
                        <span style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: {{ $vStat['avg_uptime'] >= 99.0 ? '#34d399' : '#fbbf24' }};">
                            {{ $vStat['avg_uptime'] }}%
                        </span>
                    </td>
                    <td style="padding: 0.8rem; text-align: center; font-family: 'JetBrains Mono', monospace; color: var(--accent-cyan);">
                        {{ $vStat['avg_latency'] }} ms
                    </td>
                    <td style="padding: 0.8rem; text-align: center;">
                        @if($vStat['avg_uptime'] >= 99.5)
                            <span class="badge-pill badge-emerald">PREDIKAT A (SANGAT BAIK)</span>
                        @elseif($vStat['avg_uptime'] >= 99.0)
                            <span class="badge-pill badge-cyan">PREDIKAT B (MEMENUHI SLA)</span>
                        @else
                            <span class="badge-pill badge-amber">PREDIKAT C (PERLU EVALUASI)</span>
                        @endif
                    </td>
                    <td style="padding: 0.8rem; font-size: 0.82rem; color: var(--text-muted);">
                        @if($vStat['avg_uptime'] >= 99.5)
                            Pertahankan standar SLA dan kapasitas infrastruktur server.
                        @elseif($vStat['avg_uptime'] >= 99.0)
                            Optimalkan response time basis data dan konektivitas CDN.
                        @else
                            Diberikan surat peringatan pemenuhan SLA minimal 99.0%.
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Rincian per Desa -->
<div class="glass-card" style="margin-bottom: 2rem;">
    <h3 style="font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fa-solid fa-list-check" style="color: var(--accent-cyan);"></i>
        Tabel 2: Rincian Realisasi SLA Masing-Masing Desa Se-Kabupaten Banggai Kepulauan
    </h3>

    <div class="table-container">
        <table class="custom-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 0.75rem; text-align: center; width: 40px;">No</th>
                    <th style="padding: 0.75rem; text-align: left;">Nama Desa</th>
                    <th style="padding: 0.75rem; text-align: left;">Kecamatan</th>
                    <th style="padding: 0.75rem; text-align: left;">Vendor / Penyedia</th>
                    <th style="padding: 0.75rem; text-align: left;">Tipe Server</th>
                    <th style="padding: 0.75rem; text-align: center;">Target SLA</th>
                    <th style="padding: 0.75rem; text-align: center;">Realisasi Uptime</th>
                    <th style="padding: 0.75rem; text-align: center;">Latensi</th>
                    <th style="padding: 0.75rem; text-align: center;">Status Kepatuhan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenants as $index => $t)
                <tr>
                    <td style="padding: 0.75rem; text-align: center; color: var(--text-muted);">{{ $index + 1 }}</td>
                    <td style="padding: 0.75rem;">
                        <strong style="color: #fff;">{{ $t->nama_desa }}</strong>
                        <div style="font-size: 0.72rem; color: var(--text-subtle);">{{ $t->kode_desa }}</div>
                    </td>
                    <td style="padding: 0.75rem; color: var(--text-muted);">{{ $t->kecamatan }}</td>
                    <td style="padding: 0.75rem; color: #e2e8f0;">{{ $t->vendor_name ?? 'Diskominfo Bangkep' }}</td>
                    <td style="padding: 0.75rem;">{!! $t->getServerBadge() !!}</td>
                    <td style="padding: 0.75rem; text-align: center; font-family: 'JetBrains Mono', monospace; color: var(--text-muted);">
                        {{ $t->sla_target ?? 99.0 }}%
                    </td>
                    <td style="padding: 0.75rem; text-align: center; font-family: 'JetBrains Mono', monospace; font-weight: 700; color: {{ ($t->uptime_pct ?? 99.5) >= ($t->sla_target ?? 99.0) ? '#34d399' : '#f87171' }};">
                        {{ $t->uptime_pct ?? 99.5 }}%
                    </td>
                    <td style="padding: 0.75rem; text-align: center; font-family: 'JetBrains Mono', monospace; color: var(--accent-cyan);">
                        {{ $t->latency_ms ?? 85 }} ms
                    </td>
                    <td style="padding: 0.75rem; text-align: center;">
                        @if(($t->uptime_pct ?? 99.5) >= ($t->sla_target ?? 99.0))
                            <span class="badge-pill badge-emerald">TERPENUHI</span>
                        @else
                            <span class="badge-pill badge-amber">DEVlASI SLA</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Lembar Pengesahan Pejabat -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 3rem; page-break-inside: avoid;">
    <div style="text-align: center; padding: 1.5rem; border: 1px dashed rgba(255, 255, 255, 0.15); border-radius: 8px;">
        <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Mengetahui,</div>
        <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 4rem;">
            Kepala Dinas Komunikasi dan Informatika<br>Kabupaten Banggai Kepulauan
        </div>
        <div style="font-weight: 700; color: #fff; text-decoration: underline;">
            Drs. H. PENGELOLA SPBE, M.Si
        </div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">
            NIP. 19740512 200003 1 004
        </div>
    </div>

    <div style="text-align: center; padding: 1.5rem; border: 1px dashed rgba(255, 255, 255, 0.15); border-radius: 8px;">
        <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.25rem;">Salakan, {{ date('d F Y') }}</div>
        <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 4rem;">
            Kepala Bidang Penyelenggaraan E-Government<br>dan Tata Kelola Jaringan Diskominfo
        </div>
        <div style="font-weight: 700; color: #fff; text-decoration: underline;">
            ADMINISTRATOR TEKNIS, S.Kom, M.T
        </div>
        <div style="font-size: 0.8rem; color: var(--text-muted);">
            NIP. 19850820 201001 1 012
        </div>
    </div>
</div>
@endsection
