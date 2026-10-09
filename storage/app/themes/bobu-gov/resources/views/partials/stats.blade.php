@php
    try {
        $dusunCount = class_exists(\App\Models\Wilayah::class) ? \App\Models\Wilayah::dusun()->count() : 0;
        $pendudukCount = class_exists(\App\Models\PendudukSaja::class) ? \App\Models\PendudukSaja::status()->count() : 0;
        $keluargaCount = class_exists(\App\Models\Keluarga::class) ? \App\Models\Keluarga::statusAktif()->count() : 0;
        $suratCount = class_exists(\App\Models\LogSurat::class) ? \App\Models\LogSurat::whereNull('deleted_at')->count() : 0;
        $kelompokCount = class_exists(\App\Models\Kelompok::class) ? \App\Models\Kelompok::status()->tipe()->count() : 0;
        $rtmCount = class_exists(\App\Models\Rtm::class) ? \App\Models\Rtm::status()->count() : 0;
        $bantuanCount = class_exists(\App\Models\Bantuan::class) ? \App\Models\Bantuan::count() : 0;
        $mandiriCount = class_exists(\App\Models\PendudukMandiri::class) ? \App\Models\PendudukMandiri::count() : 0;

        // Fallback to $stat_widget if Penduduk is 0
        if ($pendudukCount == 0 && !empty($stat_widget) && is_array($stat_widget)) {
            foreach ($stat_widget as $st) {
                if (($st['nama'] ?? '') == 'Total Penduduk' || ($st['nama'] ?? '') == 'Jumlah Penduduk') {
                    $pendudukCount = $st['jumlah'] ?? 0;
                }
                if (($st['nama'] ?? '') == 'Kepala Keluarga' || ($st['nama'] ?? '') == 'Jumlah Keluarga') {
                    $keluargaCount = $st['jumlah'] ?? 0;
                }
            }
        }

        $statsData = [
            [
                'label' => 'Wilayah Desa',
                'value' => $dusunCount,
                'unit'  => 'Dusun',
                'icon'  => 'fa-map-marked-alt',
                'color' => '#0d6efd',
                'bg'    => '#eff6ff',
            ],
            [
                'label' => 'Jumlah Penduduk',
                'value' => $pendudukCount,
                'unit'  => 'Jiwa',
                'icon'  => 'fa-users',
                'color' => '#10b981',
                'bg'    => '#ecfdf5',
            ],
            [
                'label' => 'Kepala Keluarga',
                'value' => $keluargaCount,
                'unit'  => 'KK',
                'icon'  => 'fa-user-friends',
                'color' => '#f59e0b',
                'bg'    => '#fffbeb',
            ],
            [
                'label' => 'Surat Tercetak',
                'value' => $suratCount,
                'unit'  => 'Berkas',
                'icon'  => 'fa-file-signature',
                'color' => '#8b5cf6',
                'bg'    => '#f5f3ff',
            ],
            [
                'label' => 'Kelompok Warga',
                'value' => $kelompokCount,
                'unit'  => 'Kelompok',
                'icon'  => 'fa-people-carry',
                'color' => '#ec4899',
                'bg'    => '#fdf2f8',
            ],
            [
                'label' => 'Rumah Tangga (RTM)',
                'value' => $rtmCount,
                'unit'  => 'RTM',
                'icon'  => 'fa-home',
                'color' => '#06b6d4',
                'bg'    => '#ecfeff',
            ],
            [
                'label' => 'Program Bantuan',
                'value' => $bantuanCount,
                'unit'  => 'Program',
                'icon'  => 'fa-hand-holding-heart',
                'color' => '#14b8a6',
                'bg'    => '#f0fdfa',
            ],
            [
                'label' => 'Layanan Mandiri',
                'value' => $mandiriCount,
                'unit'  => 'Warga',
                'icon'  => 'fa-id-badge',
                'color' => '#6366f1',
                'bg'    => '#eef2ff',
            ],
        ];
    } catch (\Throwable $e) {
        $statsData = [];
    }
@endphp

@if (!empty($statsData))
    <section class="py-6 relative z-20">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="bobu-stat-grid">
                @foreach ($statsData as $stat)
                    <div class="bobu-stat-card">
                        <div class="bobu-stat-icon" style="background-color: {{ $stat['bg'] }}; color: {{ $stat['color'] }};">
                            <i class="fas {{ $stat['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="bobu-stat-number gov-counter" data-target="{{ $stat['value'] }}">
                                {{ number_format($stat['value'], 0, ',', '.') }}
                                <span class="text-[10px] font-semibold text-slate-400 font-sans ml-0.5">{{ $stat['unit'] }}</span>
                            </div>
                            <div class="bobu-stat-label">{{ $stat['label'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
