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
        $totalPenduduk = 1428;
    }
    $totalKk = 386;
@endphp

<div class="container mx-auto px-4 lg:px-8 -mt-8 relative z-20">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Penduduk -->
        <div class="baka-stat-card">
            <div class="baka-stat-icon bg-[#e8f5e9] text-[#2b7a0b]">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="baka-stat-number gov-counter" data-target="{{ $totalPenduduk }}">{{ number_format($totalPenduduk, 0, ',', '.') }}</div>
                <div class="baka-stat-label">Total Penduduk</div>
            </div>
        </div>

        <!-- 2. Kepala Keluarga -->
        <div class="baka-stat-card">
            <div class="baka-stat-icon bg-[#e7f1ff] text-[#0d6efd]">
                <i class="fas fa-house-user"></i>
            </div>
            <div>
                <div class="baka-stat-number gov-counter" data-target="{{ $totalKk }}">{{ number_format($totalKk, 0, ',', '.') }}</div>
                <div class="baka-stat-label">Kepala Keluarga</div>
            </div>
        </div>

        <!-- 3. Layanan Digital 100% -->
        <div class="baka-stat-card">
            <div class="baka-stat-icon bg-[#fef9c3] text-[#ca8a04]">
                <i class="fas fa-file-contract"></i>
            </div>
            <div>
                <div class="baka-stat-number"><span class="gov-counter" data-target="100">100</span>%</div>
                <div class="baka-stat-label">Layanan Surat Digital</div>
            </div>
        </div>

        <!-- 4. Status Desa Mandiri -->
        <div class="baka-stat-card">
            <div class="baka-stat-icon bg-[#f3e8ff] text-[#7e22ce]">
                <i class="fas fa-award"></i>
            </div>
            <div>
                <div class="baka-stat-number text-xl text-[#7e22ce]">MANDIRI</div>
                <div class="baka-stat-label">Status IDM Desa</div>
            </div>
        </div>
    </div>
</div>
