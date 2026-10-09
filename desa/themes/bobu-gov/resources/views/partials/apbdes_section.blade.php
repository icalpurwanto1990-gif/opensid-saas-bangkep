@php
    $tahunAnggaran = setting('apbdes_tahun') ?: date('Y');
    $lat = $desa['lat'] ?? '-1.4586';
    $lng = $desa['lng'] ?? '123.2386';
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $alamatKantor = $desa['kantor_desa'] ?? 'Jl. Trans Pesisir Bobu';
@endphp

<section class="py-12 bg-white border-y border-slate-100">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            <!-- Left: Transparansi Keuangan APBDes (7 cols) -->
            <div class="lg:col-span-7 flex flex-col justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#0d6efd] bg-blue-50 px-3.5 py-1.5 rounded-full mb-3 border border-blue-100">
                        <i class="fas fa-chart-pie"></i> Akuntabilitas Publik
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-[#1a202c]">Transparansi APBDes {{ $tahunAnggaran }}</h2>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 mb-6">Laporan keterbukaan anggaran pendapatan, belanja, dan pembiayaan pembangunan Desa Bobu.</p>

                    @if (!empty($transparansi) && is_array($transparansi))
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if (isset($transparansi['pendapatan']))
                                <div class="p-5 rounded-[20px] bg-[#f8fafc] border border-slate-200 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-[#10b981]">Pendapatan</span>
                                        <span class="w-7 h-7 rounded-full bg-emerald-50 text-[#10b981] flex items-center justify-center text-xs"><i class="fas fa-arrow-down"></i></span>
                                    </div>
                                    <div class="text-lg font-extrabold text-[#1a202c] mb-1">{{ rupiah($transparansi['pendapatan']['anggaran'] ?? 0) }}</div>
                                    <div class="text-[11px] text-slate-500 mb-2">Realisasi: {{ $transparansi['pendapatan']['persen'] ?? 0 }}%</div>
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-[#10b981] h-full rounded-full" style="width: {{ min(100, $transparansi['pendapatan']['persen'] ?? 0) }}%;"></div>
                                    </div>
                                </div>
                            @endif

                            @if (isset($transparansi['belanja']))
                                <div class="p-5 rounded-[20px] bg-[#f8fafc] border border-slate-200 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-rose-600">Belanja</span>
                                        <span class="w-7 h-7 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-xs"><i class="fas fa-arrow-up"></i></span>
                                    </div>
                                    <div class="text-lg font-extrabold text-[#1a202c] mb-1">{{ rupiah($transparansi['belanja']['anggaran'] ?? 0) }}</div>
                                    <div class="text-[11px] text-slate-500 mb-2">Realisasi: {{ $transparansi['belanja']['persen'] ?? 0 }}%</div>
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-rose-500 h-full rounded-full" style="width: {{ min(100, $transparansi['belanja']['persen'] ?? 0) }}%;"></div>
                                    </div>
                                </div>
                            @endif

                            @if (isset($transparansi['pembiayaan']))
                                <div class="p-5 rounded-[20px] bg-[#f8fafc] border border-slate-200 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-[#0d6efd]">Pembiayaan</span>
                                        <span class="w-7 h-7 rounded-full bg-blue-50 text-[#0d6efd] flex items-center justify-center text-xs"><i class="fas fa-balance-scale"></i></span>
                                    </div>
                                    <div class="text-lg font-extrabold text-[#1a202c] mb-1">{{ rupiah($transparansi['pembiayaan']['anggaran'] ?? 0) }}</div>
                                    <div class="text-[11px] text-slate-500 mb-2">Realisasi: {{ $transparansi['pembiayaan']['persen'] ?? 0 }}%</div>
                                    <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-[#0d6efd] h-full rounded-full" style="width: {{ min(100, $transparansi['pembiayaan']['persen'] ?? 0) }}%;"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Card Ringkasan Transparansi Anggaran Terbuka -->
                        <div class="p-6 rounded-[20px] bg-[#f8fafc] border border-slate-200 flex flex-col sm:flex-row items-center gap-5">
                            <div class="w-14 h-14 rounded-full bg-blue-50 text-[#0d6efd] flex items-center justify-center text-2xl shrink-0">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-extrabold text-[#1a202c]">Keterbukaan Informasi Pengelolaan Dana Desa</h4>
                                <p class="text-xs text-slate-500 mt-1">Data realisasi pelaksanaan anggaran pendapatan dan belanja desa dikelola secara profesional melalui Sistem Keuangan Desa (Siskeudes) & modul keuangan OpenSID.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-6">
                    <a href="{{ site_url('apbdes') }}" class="btn-bobu-outline !text-xs">
                        <i class="fas fa-file-alt"></i> Lihat Detail Laporan APBDes
                    </a>
                </div>
            </div>

            <!-- Right: Peta Wilayah Desa Bobu (5 cols) -->
            <div class="lg:col-span-5 flex flex-col justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#10b981] bg-emerald-50 px-3.5 py-1.5 rounded-full mb-3 border border-emerald-100">
                        <i class="fas fa-map-marked-alt"></i> Geografis & Wilayah
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-[#1a202c]">Peta Wilayah Desa</h2>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 mb-4">Lokasi kantor desa, batas wilayah administratif, dan pemetaan potensi ruang Desa Bobu.</p>

                    <div class="relative rounded-[20px] overflow-hidden border border-slate-200 bg-[#f8fafc] shadow-sm aspect-[16/10]">
                        <!-- Interactive OpenStreetMap / Map Preview -->
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                src="https://www.openstreetmap.org/export/embed.html?bbox=123.15%2C-1.52%2C123.35%2C-1.40&amp;layer=mapnik&amp;marker={{ $lat }}%2C{{ $lng }}"
                                class="w-full h-full border-0">
                        </iframe>
                        <div class="absolute bottom-3 left-3 right-3 bg-white/95 backdrop-blur-sm p-3 rounded-[14px] border border-slate-200/80 flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-pin text-rose-500"></i>
                                <span class="text-xs font-bold text-[#1a202c]">Kantor Desa {{ ucwords($namaDesa) }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $lat }}, {{ $lng }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-medium truncate mr-2">
                        <i class="fas fa-building text-slate-400 mr-1"></i> {{ $alamatKantor }}
                    </span>
                    <a href="{{ site_url('peta') }}" class="btn-bobu-green !text-xs shrink-0">
                        <i class="fas fa-external-link-alt text-xs"></i> Buka Peta Full
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
