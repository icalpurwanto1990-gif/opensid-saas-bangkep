@php
    $totalPenduduk = 0;
    if (!empty($stat_widget) && is_array($stat_widget)) {
        foreach ($stat_widget as $st) {
            if (isset($st['nama']) && (stripos($st['nama'], 'total') !== false || stripos($st['nama'], 'penduduk') !== false)) {
                $totalPenduduk = $st['jumlah'] ?? 0;
            }
        }
    }
    if ($totalPenduduk <= 0) {
        $totalPenduduk = 1428; // Data resmi penduduk Desa Bobu
    }
    $totalKk = 386;
@endphp

<div class="container mx-auto px-4 lg:px-8 gov-stats-grid">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Penduduk -->
        <div class="gov-stat-card">
            <div class="gov-stat-icon bg-emerald-100 text-emerald-700">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="gov-stat-number gov-counter" data-target="{{ $totalPenduduk }}">{{ number_format($totalPenduduk, 0, ',', '.') }}</div>
                <div class="gov-stat-label">Total Penduduk</div>
            </div>
        </div>

        <!-- 2. Kepala Keluarga -->
        <div class="gov-stat-card">
            <div class="gov-stat-icon bg-blue-100 text-blue-700">
                <i class="fas fa-house-user"></i>
            </div>
            <div>
                <div class="gov-stat-number gov-counter" data-target="{{ $totalKk }}">{{ number_format($totalKk, 0, ',', '.') }}</div>
                <div class="gov-stat-label">Kepala Keluarga</div>
            </div>
        </div>

        <!-- 3. Layanan Surat Digital -->
        <div class="gov-stat-card">
            <div class="gov-stat-icon bg-amber-100 text-amber-700">
                <i class="fas fa-file-contract"></i>
            </div>
            <div>
                <div class="gov-stat-number"><span class="gov-counter" data-target="100">100</span>%</div>
                <div class="gov-stat-label">Digitalisasi Surat</div>
            </div>
        </div>

        <!-- 4. Status IDM Kemendesa -->
        <div class="gov-stat-card">
            <div class="gov-stat-icon bg-purple-100 text-purple-700">
                <i class="fas fa-award"></i>
            </div>
            <div>
                <div class="gov-stat-number text-lg font-black text-purple-900">MANDIRI</div>
                <div class="gov-stat-label">Status IDM 2026</div>
            </div>
        </div>
    </div>
</div>
