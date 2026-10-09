@php
    $tahunAnggaran = setting('apbdes_tahun') ?: date('Y');
@endphp

@if (!empty($transparansi) && is_array($transparansi))
    <section class="py-16 bg-[#f6f6f6] border-b border-slate-200">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-black bg-[#87de57] px-3.5 py-1.5 rounded-full mb-2.5">
                        <i class="fas fa-chart-line"></i> Akuntabilitas
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-black">Transparansi Anggaran (APBDes {{ $tahunAnggaran }})</h2>
                    <p class="text-xs md:text-sm text-slate-600 mt-1.5">Laporan realisasi Anggaran Pendapatan dan Belanja Desa demi akuntabilitas pembangunan desa.</p>
                </div>
                <a href="{{ site_url('apbdes') }}" class="text-xs font-bold text-[#029019] hover:text-black flex items-center gap-1.5">
                    Laporan Rinci APBDes <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if (isset($transparansi['pendapatan']))
                    <div class="p-8 rounded-[16px] bg-white border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#029019]">Pendapatan Desa</span>
                            <span class="w-8 h-8 rounded-full bg-[#f0fdf4] text-[#029019] flex items-center justify-center text-xs"><i class="fas fa-arrow-down"></i></span>
                        </div>
                        <div class="text-xl md:text-2xl font-black text-black mb-1">{{ rupiah($transparansi['pendapatan']['anggaran'] ?? 0) }}</div>
                        <div class="text-[11px] text-slate-600 mb-3">Realisasi: {{ rupiah($transparansi['pendapatan']['realisasi'] ?? 0) }} ({{ $transparansi['pendapatan']['persen'] ?? 0 }}%)</div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-[#87de57] h-full rounded-full" style="width: {{ min(100, $transparansi['pendapatan']['persen'] ?? 0) }}%;"></div>
                        </div>
                    </div>
                @endif

                @if (isset($transparansi['belanja']))
                    <div class="p-8 rounded-[16px] bg-white border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-rose-700">Belanja Desa</span>
                            <span class="w-8 h-8 rounded-full bg-rose-50 text-rose-700 flex items-center justify-center text-xs"><i class="fas fa-arrow-up"></i></span>
                        </div>
                        <div class="text-xl md:text-2xl font-black text-black mb-1">{{ rupiah($transparansi['belanja']['anggaran'] ?? 0) }}</div>
                        <div class="text-[11px] text-slate-600 mb-3">Realisasi: {{ rupiah($transparansi['belanja']['realisasi'] ?? 0) }} ({{ $transparansi['belanja']['persen'] ?? 0 }}%)</div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full" style="width: {{ min(100, $transparansi['belanja']['persen'] ?? 0) }}%;"></div>
                        </div>
                    </div>
                @endif

                @if (isset($transparansi['pembiayaan']))
                    <div class="p-8 rounded-[16px] bg-white border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Pembiayaan Neto</span>
                            <span class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center text-xs"><i class="fas fa-balance-scale"></i></span>
                        </div>
                        <div class="text-xl md:text-2xl font-black text-black mb-1">{{ rupiah($transparansi['pembiayaan']['anggaran'] ?? 0) }}</div>
                        <div class="text-[11px] text-slate-600 mb-3">Realisasi: {{ rupiah($transparansi['pembiayaan']['realisasi'] ?? 0) }} ({{ $transparansi['pembiayaan']['persen'] ?? 0 }}%)</div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-600 h-full rounded-full" style="width: {{ min(100, $transparansi['pembiayaan']['persen'] ?? 0) }}%;"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
