@extends('diskominfo::layouts.master')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
        <div>
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #fff;">
                <i class="fa-solid fa-heart-pulse" style="color: var(--accent-emerald); margin-right: 0.5rem;"></i>
                Pusat Pemantauan SLA & Keandalan Vendor Server Desa
            </h2>
            <p style="color: var(--text-muted); font-size: 0.92rem; margin-top: 0.25rem;">
                Monitoring Service Level Agreement (SLA), waktu respon server (latency), dan kelaikan operasional website desa lintas vendor di Kabupaten Banggai Kepulauan.
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="{{ site_url('diskominfo/laporan') }}" class="btn-action btn-outline" style="font-size: 0.85rem;">
                <i class="fa-solid fa-file-pdf"></i> Unduh Laporan Bupati
            </a>
            <a href="{{ site_url('diskominfo/sla/ping') }}" class="btn-action btn-cyan" style="font-size: 0.85rem;">
                <i class="fa-solid fa-bolt"></i> Live Ping Seluruh Server
            </a>
        </div>
    </div>
</div>

@if(isset($_GET['pinged']))
<div class="glass-card" style="border-color: rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.1); margin-bottom: 1.5rem; padding: 1rem 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-circle-check" style="color: var(--accent-emerald); font-size: 1.25rem;"></i>
        <div>
            <strong style="color: #fff;">Uji Kesehatan Server Berhasil:</strong>
            <span style="color: var(--text-main);">{{ htmlspecialchars($_GET['pinged']) }} merespon dengan status <code style="color: var(--accent-cyan);">{{ htmlspecialchars($_GET['status'] ?? 'online') }}</code> (Latensi: {{ htmlspecialchars($_GET['latency'] ?? '0') }}ms).</span>
        </div>
    </div>
</div>
@endif

<!-- SLA Executive Stat Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
    <!-- Rata-rata Uptime -->
    <div class="glass-card" style="border-top: 3px solid var(--accent-cyan);">
        <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600; text-transform: uppercase;">
            Rata-Rata Uptime Kabupaten
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem;">
            {{ $slaSummary['avg_uptime_kabupaten'] ?? 98.8 }}%
        </div>
        <div style="font-size: 0.8rem; color: var(--accent-cyan); display: flex; align-items: center; gap: 0.4rem;">
            <i class="fa-solid fa-bullseye"></i> Target Kontrak SLA: ≥ {{ $slaSummary['target_sla_standar'] ?? 99.0 }}%
        </div>
    </div>

    <!-- Live Status Server -->
    <div class="glass-card" style="border-top: 3px solid var(--accent-emerald);">
        <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600; text-transform: uppercase;">
            Status Server Real-Time
        </div>
        <div style="font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem; display: flex; gap: 0.75rem; align-items: center;">
            <span style="color: var(--accent-emerald); font-size: 1.8rem;">{{ $slaSummary['total_online'] ?? 0 }}</span>
            <span style="font-size: 0.85rem; color: var(--text-muted);">Online</span>
            <span style="color: var(--accent-amber); font-size: 1.4rem;">• {{ $slaSummary['total_degraded'] ?? 0 }}</span>
            <span style="font-size: 0.85rem; color: var(--text-muted);">Slow</span>
            <span style="color: var(--accent-rose); font-size: 1.4rem;">• {{ $slaSummary['total_offline'] ?? 0 }}</span>
            <span style="font-size: 0.85rem; color: var(--text-muted);">Down</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--accent-emerald);">
            <i class="fa-solid fa-server"></i> Total {{ $slaSummary['total_desa_terpantau'] ?? 0 }} Simpul Server Terdaftar
        </div>
    </div>

    <!-- Latensi Respon Rata-rata -->
    <div class="glass-card" style="border-top: 3px solid var(--accent-blue);">
        <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600; text-transform: uppercase;">
            Rata-Rata Latensi Respon
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem;">
            {{ $slaSummary['avg_latency_ms'] ?? 85 }} <span style="font-size: 1.1rem; color: var(--text-muted); font-weight: 500;">ms</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--accent-emerald);">
            <i class="fa-solid fa-gauge-high"></i> Kategori Kecepatan: Optimal (< 300ms)
        </div>
    </div>

    <!-- Kepatuhan Kontrak Vendor -->
    <div class="glass-card" style="border-top: 3px solid var(--accent-amber);">
        <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0.5rem; font-weight: 600; text-transform: uppercase;">
            Mitra Vendor Terdata
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem;">
            {{ count($slaSummary['vendor_rankings'] ?? []) }} <span style="font-size: 1.1rem; color: var(--text-muted); font-weight: 500;">Penyedia</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--accent-amber);">
            <i class="fa-solid fa-handshake"></i> Standarisasi SLA Dinas Kominfo
        </div>
    </div>
</div>

<!-- Vendor Scorecard & Reliability Ranking -->
<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #fff;">
                <i class="fa-solid fa-award" style="color: var(--accent-amber); margin-right: 0.5rem;"></i>
                Papan Skor & Peringkat Keandalan Vendor Penyedia Website Desa
            </h3>
            <p style="font-size: 0.82rem; color: var(--text-muted); margin-top: 0.2rem;">
                Dievaluasi berdasarkan uptime aktual 30 hari terakhir dan latensi akses masyarakat di Kepulauan Banggai.
            </p>
        </div>
        <span class="badge-pill badge-cyan" style="font-size: 0.75rem;">
            Audit SLA Q4 2026
        </span>
    </div>

    <div class="table-container">
        <table class="custom-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">Peringkat</th>
                    <th style="padding: 1rem;">Nama Vendor Penyedia</th>
                    <th style="padding: 1rem;">Tipe Infrastruktur</th>
                    <th style="padding: 1rem;">Desa Dikelola</th>
                    <th style="padding: 1rem;">Uptime Aktual</th>
                    <th style="padding: 1rem;">Rata-rata Latensi</th>
                    <th style="padding: 1rem;">Status Kepatuhan SLA</th>
                    <th style="padding: 1rem;">Kontak Teknis</th>
                </tr>
            </thead>
            <tbody>
                @foreach(($slaSummary['vendor_rankings'] ?? []) as $idx => $v)
                <tr>
                    <td style="padding: 1rem; font-weight: 800; font-size: 1.1rem; color: {{ $idx == 0 ? 'var(--accent-amber)' : ($idx == 1 ? '#cbd5e1' : '#94a3b8') }};">
                        #{{ $idx + 1 }}
                    </td>
                    <td style="padding: 1rem;">
                        <strong style="color: #fff; font-size: 0.95rem;">{{ $v['nama'] }}</strong>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge-pill badge-blue" style="font-size: 0.75rem;">{{ $v['tipe_server'] }}</span>
                    </td>
                    <td style="padding: 1rem;">
                        <strong>{{ $v['total_desa'] }}</strong> Website Desa
                    </td>
                    <td style="padding: 1rem;">
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 1rem; font-weight: 700; color: {{ $v['avg_uptime'] >= 99 ? 'var(--accent-emerald)' : ($v['avg_uptime'] >= 95 ? 'var(--accent-amber)' : 'var(--accent-rose)') }};">
                            {{ number_format($v['avg_uptime'], 2) }}%
                        </span>
                    </td>
                    <td style="padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                        {{ $v['avg_latency'] }} ms
                    </td>
                    <td style="padding: 1rem;">
                        @if($v['avg_uptime'] >= 99.0)
                            <span class="badge-pill badge-emerald"><i class="fa-solid fa-check"></i> Memenuhi Standar</span>
                        @elseif($v['avg_uptime'] >= 95.0)
                            <span class="badge-pill badge-yellow"><i class="fa-solid fa-triangle-exclamation"></i> Perlu Evaluasi</span>
                        @else
                            <span class="badge-pill badge-red"><i class="fa-solid fa-xmark"></i> Kritis (SLA Breach)</span>
                        @endif
                    </td>
                    <td style="padding: 1rem; font-size: 0.8rem; color: var(--text-subtle);">
                        {{ $v['kontak'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- All Villages Live SLA Table -->
<div class="glass-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #fff;">
                <i class="fa-solid fa-server" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
                Monitoring Kesehatan Seluruh Simpul Website Desa
            </h3>
            <p style="font-size: 0.82rem; color: var(--text-muted); margin-top: 0.2rem;">
                Data kesehatan server dan parameter latensi waktu respon per desa.
            </p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ site_url('diskominfo/desa/create') }}" class="btn-action btn-cyan" style="font-size: 0.75rem;">
                <i class="fa-solid fa-plus"></i> Tambah Desa / Vendor Eksternal
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="custom-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">Desa / Wilayah</th>
                    <th style="padding: 1rem;">Infrastruktur & Vendor</th>
                    <th style="padding: 1rem;">Target SLA</th>
                    <th style="padding: 1rem;">Realisasi Uptime</th>
                    <th style="padding: 1rem;">Latensi Waktu Respon</th>
                    <th style="padding: 1rem;">Status Server</th>
                    <th style="padding: 1rem;">Pengecekan Terakhir</th>
                    <th style="padding: 1rem;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenants as $t)
                <tr>
                    <td style="padding: 1rem;">
                        <strong style="color: #fff; font-size: 0.95rem;">{{ $t->nama_desa }}</strong>
                        <div style="font-size: 0.75rem; color: var(--text-subtle);">Kec. {{ $t->kecamatan }}</div>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="font-size: 0.88rem; color: #fff;">{{ $t->vendor_name ?: 'Vendor Mandiri' }}</div>
                        <span class="badge-pill {{ $t->server_type_badge }}" style="font-size: 0.65rem; margin-top: 0.25rem;">
                            {{ $t->server_type_label }}
                        </span>
                    </td>
                    <td style="padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--text-muted);">
                        ≥ {{ number_format($t->sla_target ?? 99, 1) }}%
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge-pill {{ $t->sla_badge_class }}" style="font-family: 'JetBrains Mono', monospace; font-size: 0.82rem;">
                            {{ number_format($t->uptime_pct ?? 99, 2) }}%
                        </span>
                    </td>
                    <td style="padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                        <span style="color: {{ ($t->latency_ms ?? 0) < 300 ? 'var(--accent-emerald)' : (($t->latency_ms ?? 0) < 1000 ? 'var(--accent-amber)' : 'var(--accent-rose)') }}; font-weight: 700;">
                            {{ $t->latency_ms ?? 50 }} ms
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge-pill {{ $t->status_badge_class }}">
                            <span class="pulse-dot"></span> {{ ucfirst($t->last_status ?? 'online') }}
                        </span>
                    </td>
                    <td style="padding: 1rem; font-size: 0.78rem; color: var(--text-muted);">
                        {{ $t->last_ping_at ?? 'Baru saja' }}
                    </td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; gap: 0.4rem;">
                            <a href="{{ site_url('diskominfo/sla/ping/' . $t->slug) }}" class="btn-action btn-outline" style="font-size: 0.72rem; padding: 0.3rem 0.6rem;" title="Uji Koneksi Server">
                                <i class="fa-solid fa-bolt"></i> Ping
                            </a>
                            <a href="{{ $t->url }}" target="_blank" class="btn-action btn-cyan" style="font-size: 0.72rem; padding: 0.3rem 0.6rem;">
                                Buka <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Incident History Log -->
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #fff;">
                <i class="fa-solid fa-triangle-exclamation" style="color: var(--accent-rose); margin-right: 0.5rem;"></i>
                Log Insiden Gangguan Server & Catatan SLA Terkini
            </h3>
            <p style="font-size: 0.82rem; color: var(--text-muted); margin-top: 0.2rem;">
                Riwayat kegagalan respon server atau lonjakan latensi yang tercatat oleh sistem pengawasan Diskominfo.
            </p>
        </div>
        <span class="badge-pill badge-yellow" style="font-size: 0.75rem;">
            Otomasi Pencatatan
        </span>
    </div>

    <div class="table-container">
        <table class="custom-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 1rem;">Waktu Kejadian</th>
                    <th style="padding: 1rem;">Desa / Wilayah</th>
                    <th style="padding: 1rem;">Vendor Penanggung Jawab</th>
                    <th style="padding: 1rem;">Jenis Insiden</th>
                    <th style="padding: 1rem;">Kode HTTP</th>
                    <th style="padding: 1rem;">Keterangan & Rekomendasi Diskominfo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $inc)
                <tr>
                    <td style="padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--text-muted);">
                        {{ $inc['recorded_at'] }}
                    </td>
                    <td style="padding: 1rem; font-weight: 700; color: #fff;">
                        {{ $inc['nama_desa'] }}
                    </td>
                    <td style="padding: 1rem; font-size: 0.85rem; color: var(--accent-cyan);">
                        {{ $inc['vendor_name'] }}
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge-pill {{ $inc['severity'] == 'danger' ? 'badge-red' : ($inc['severity'] == 'warning' ? 'badge-yellow' : 'badge-emerald') }}" style="font-size: 0.75rem;">
                            {{ $inc['incident_type'] }}
                        </span>
                    </td>
                    <td style="padding: 1rem; font-family: 'JetBrains Mono', monospace; font-size: 0.85rem;">
                        HTTP {{ $inc['status_code'] }}
                    </td>
                    <td style="padding: 1rem; font-size: 0.85rem; color: var(--text-main);">
                        {{ $inc['message'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
