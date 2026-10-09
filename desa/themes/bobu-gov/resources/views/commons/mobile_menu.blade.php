<!-- Backdrop Overlay -->
<div id="govMobileOverlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 hidden transition-opacity"></div>

<!-- Slide-out Drawer Menu -->
<div id="govMobileDrawer" class="fixed inset-y-0 left-0 w-80 max-w-[85vw] bg-slate-900 text-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col shadow-2xl">
    <!-- Header Drawer -->
    <div class="p-4 bg-slate-950 border-b border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo" class="w-9 h-9 object-contain">
            <div>
                <div class="text-xs font-bold text-amber-400">PEMERINTAH DESA</div>
                <div class="text-sm font-extrabold text-white">BOBU</div>
            </div>
        </div>
        <button id="govMobileCloseBtn" type="button" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-300 hover:text-white hover:bg-slate-700">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Mobile Search Form -->
    <div class="p-4 border-b border-slate-800">
        <form action="{{ site_url('/') }}" method="get" class="relative">
            <input type="text" name="cari" placeholder="Cari layanan, berita..."
                   class="w-full bg-slate-800 text-white text-xs rounded-lg pl-9 pr-3 py-2.5 border border-slate-700 focus:outline-none focus:border-emerald-500">
            <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-xs"></i>
        </form>
    </div>

    <!-- Quick Action Links -->
    <div class="p-4 grid grid-cols-2 gap-2 border-b border-slate-800 bg-slate-950/50">
        <a href="{{ site_url('layanan-mandiri') }}" class="p-2.5 rounded-lg bg-emerald-600/20 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2 hover:bg-emerald-600/30">
            <i class="fas fa-id-card"></i> Mandiri NIK
        </a>
        <a href="{{ site_url('pengaduan') }}" class="p-2.5 rounded-lg bg-amber-600/20 border border-amber-500/30 text-amber-300 text-xs font-semibold flex items-center gap-2 hover:bg-amber-600/30">
            <i class="fas fa-bullhorn"></i> Pengaduan
        </a>
    </div>

    <!-- Scrollable Navigation Tree -->
    <div class="flex-1 overflow-y-auto p-4 space-y-1">
        <a href="{{ site_url('/') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800 text-slate-200">
            <i class="fas fa-home text-amber-400 mr-2.5"></i> Beranda Utama
        </a>

        @if (menu_tema())
            @foreach (menu_tema() as $index => $menu)
                @php $has_dropdown = count($menu['childrens'] ?? []) > 0 @endphp
                <div class="space-y-1">
                    @if ($has_dropdown)
                        <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-t border-slate-800/60">
                            {!! $menu['nama'] !!}
                        </div>
                        @foreach ($menu['childrens'] as $child)
                            <a href="{{ $child['link_url'] }}" class="block px-5 py-2 rounded-md text-xs font-medium text-slate-300 hover:text-white hover:bg-emerald-600/30">
                                <i class="fas fa-angle-right text-[10px] text-emerald-400 mr-2"></i> {!! $child['nama'] !!}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ $menu['link_url'] }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-800 text-slate-200">
                            <i class="fas fa-circle text-[7px] text-emerald-400 mr-2.5"></i> {!! $menu['nama'] !!}
                        </a>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <!-- Footer Drawer -->
    <div class="p-4 border-t border-slate-800 bg-slate-950 text-center text-[11px] text-slate-400">
        <div>Kec. Tinangkung Selatan, Bangkep</div>
        <div class="text-[10px] text-slate-400 mt-1">&copy; {{ date('Y') }} Pemerintah Desa Bobu</div>
    </div>
</div>
