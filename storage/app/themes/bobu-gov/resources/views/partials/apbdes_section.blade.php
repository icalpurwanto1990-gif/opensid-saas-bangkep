@php
    $tahunAnggaran = setting('apbdes_tahun') ?: date('Y');
@endphp

<section class="py-12 bg-white border-y border-slate-200">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-100 px-3 py-1 rounded-full mb-2">
                    <i class="fas fa-chart-line"></i> Akuntabilitas Publik
                </div>
                <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900">Transparansi Anggaran (APBDes {{ $tahunAnggaran }})</h3>
                <p class="text-xs md:text-sm text-slate-600 mt-1">Laporan realisasi Anggaran Pendapatan dan Belanja Desa demi akuntabilitas pembangunan berkelanjutan.</p>
            </div>
            <a href="{{ site_url('apbdes') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1">
                Laporan Rinci APBDes <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- 1. Pendapatan Desa -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Pendapatan Desa</span>
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm"><i class="fas fa-arrow-down"></i></span>
                </div>
                <div class="text-xl md:text-2xl font-black text-slate-900 mb-1">Rp 1.185.450.000</div>
                <div class="text-[11px] text-slate-500 mb-3">Realisasi: Rp 1.050.200.000 (88,5%)</div>
                <div class="gov-budget-progress">
                    <div class="gov-budget-fill" style="width: 88.5%;"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2">Sumber: Dana Desa, ADD, Bagi Hasil Pajak</div>
            </div>

            <!-- 2. Belanja Desa -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-700">Belanja Desa</span>
                    <span class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-sm"><i class="fas fa-arrow-up"></i></span>
                </div>
                <div class="text-xl md:text-2xl font-black text-slate-900 mb-1">Rp 1.140.200.000</div>
                <div class="text-[11px] text-slate-500 mb-3">Realisasi: Rp 985.400.000 (86,4%)</div>
                <div class="gov-budget-progress">
                    <div class="gov-budget-fill !bg-gradient-to-r !from-rose-500 !to-rose-600" style="width: 86.4%;"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2">Penyelenggaraan Pemdes, Pembangunan, Pemberdayaan</div>
            </div>

            <!-- 3. Pembiayaan Desa -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Pembiayaan Neto</span>
                    <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-sm"><i class="fas fa-balance-scale"></i></span>
                </div>
                <div class="text-xl md:text-2xl font-black text-slate-900 mb-1">Rp 45.250.000</div>
                <div class="text-[11px] text-slate-500 mb-3">Realisasi: Rp 45.250.000 (100%)</div>
                <div class="gov-budget-progress">
                    <div class="gov-budget-fill !bg-gradient-to-r !from-blue-500 !to-blue-600" style="width: 100%;"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2">Penyertaan Modal BUMDes & Silpa Tahun Lalu</div>
            </div>
        </div>
    </div>
</section>
