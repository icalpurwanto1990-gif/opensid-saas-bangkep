@php
    $tahunAnggaran = setting('apbdes_tahun') ?: date('Y');
@endphp

<section class="py-14 bg-transparent border-t border-slate-200/80">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-blue-800 bg-[#e7f1ff] px-3.5 py-1.5 rounded-full mb-2.5">
                    <i class="fas fa-chart-line"></i> Akuntabilitas Publik
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#2d3748]">Transparansi Anggaran (APBDes {{ $tahunAnggaran }})</h2>
                <p class="text-xs md:text-sm text-[#666666] mt-1.5">Laporan realisasi Anggaran Pendapatan dan Belanja Desa demi akuntabilitas pembangunan desa digital.</p>
            </div>
            <a href="{{ site_url('apbdes') }}" class="text-xs font-bold text-[#0d6efd] hover:text-blue-800 flex items-center gap-1.5">
                Rincian Lengkap APBDes <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- 1. Pendapatan Desa -->
            <div class="p-7 rounded-[20px] bg-white border border-slate-200/90 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.02)]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Pendapatan Desa</span>
                    <span class="w-8 h-8 rounded-full bg-[#e8f5e9] text-[#2b7a0b] flex items-center justify-center text-xs"><i class="fas fa-arrow-down"></i></span>
                </div>
                <div class="text-xl md:text-2xl font-black text-[#2d3748] mb-1">Rp 1.185.450.000</div>
                <div class="text-[11px] text-[#666666] mb-3">Realisasi: Rp 1.050.200.000 (88,5%)</div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-[#2b7a0b] h-full rounded-full" style="width: 88.5%;"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2.5">Sumber: Dana Desa, ADD, Bagi Hasil Pajak</div>
            </div>

            <!-- 2. Belanja Desa -->
            <div class="p-7 rounded-[20px] bg-white border border-slate-200/90 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.02)]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-800">Belanja Desa</span>
                    <span class="w-8 h-8 rounded-full bg-[#ffe4e6] text-[#e11d48] flex items-center justify-center text-xs"><i class="fas fa-arrow-up"></i></span>
                </div>
                <div class="text-xl md:text-2xl font-black text-[#2d3748] mb-1">Rp 1.140.200.000</div>
                <div class="text-[11px] text-[#666666] mb-3">Realisasi: Rp 985.400.000 (86,4%)</div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-[#e11d48] h-full rounded-full" style="width: 86.4%;"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2.5">Penyelenggaraan Pemdes, Pembangunan, Pemberdayaan</div>
            </div>

            <!-- 3. Pembiayaan Desa -->
            <div class="p-7 rounded-[20px] bg-white border border-slate-200/90 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.02)]">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-800">Pembiayaan Neto</span>
                    <span class="w-8 h-8 rounded-full bg-[#e7f1ff] text-[#0d6efd] flex items-center justify-center text-xs"><i class="fas fa-balance-scale"></i></span>
                </div>
                <div class="text-xl md:text-2xl font-black text-[#2d3748] mb-1">Rp 45.250.000</div>
                <div class="text-[11px] text-[#666666] mb-3">Realisasi: Rp 45.250.000 (100%)</div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-[#0d6efd] h-full rounded-full" style="width: 100%;"></div>
                </div>
                <div class="text-[10px] text-slate-400 mt-2.5">Penyertaan Modal BUMDes & Silpa Tahun Lalu</div>
            </div>
        </div>
    </div>
</section>
