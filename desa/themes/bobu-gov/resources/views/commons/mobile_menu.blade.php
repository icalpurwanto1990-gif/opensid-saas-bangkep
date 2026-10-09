<!-- Backdrop Overlay -->
<div id="govMobileOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden transition-opacity"></div>

<!-- Slide-out Drawer Menu (Bobu Modern Government) -->
<div id="govMobileDrawer" class="fixed inset-y-0 left-0 w-80 max-w-[85vw] bg-white text-[#2d3748] z-50 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col shadow-2xl font-['Plus_Jakarta_Sans',sans-serif]">
    <!-- Header Drawer -->
    <div class="p-5 bg-blue-50 border-b border-blue-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo" class="w-10 h-10 object-contain">
            <div>
                <div class="text-[10px] font-bold text-slate-500 uppercase">PEMERINTAH DESA</div>
                <div class="text-base font-extrabold text-[#1a202c]">BOBU</div>
            </div>
        </div>
        <button id="govMobileCloseBtn" type="button" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-slate-600 hover:text-red-600 shadow-sm">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>

    <!-- Mobile Search Form -->
    <div class="p-4 border-b border-slate-100 bg-white">
        <form action="{{ site_url('/') }}" method="get" class="relative">
            <input type="text" name="cari" placeholder="Cari layanan, berita..."
                   class="w-full bg-[#f8fafc] text-[#2d3748] text-xs rounded-full pl-9 pr-4 py-2.5 border border-slate-200 focus:outline-none focus:border-[#0d6efd]">
            <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
        </form>
    </div>

    <!-- Quick Action Links -->
    <div class="p-4 grid grid-cols-2 gap-2 border-b border-slate-100 bg-white">
        <a href="{{ site_url('layanan-mandiri') }}" class="p-2.5 rounded-full bg-[#0d6efd] text-white text-xs font-bold text-center hover:bg-[#0b5ed7] transition shadow-sm">
            <i class="fas fa-id-card"></i> Mandiri NIK
        </a>
        <a href="{{ site_url('pengaduan') }}" class="p-2.5 rounded-full bg-[#10b981] text-white text-xs font-bold text-center hover:bg-[#059669] transition shadow-sm">
            <i class="fas fa-comment-dots"></i> Pengaduan
        </a>
    </div>

    <!-- Navigation Tree -->
    <div class="flex-1 overflow-y-auto p-4 space-y-1">
        <a href="{{ site_url('/') }}" class="block px-4 py-2.5 rounded-xl text-sm font-bold bg-blue-50 text-[#0d6efd]">
            <i class="fas fa-home mr-2.5 text-[#0d6efd]"></i> Beranda Utama
        </a>

        @if (menu_tema())
            @foreach (menu_tema() as $index => $menu)
                @php $has_dropdown = count($menu['childrens'] ?? []) > 0 @endphp
                <div class="space-y-1">
                    @if ($has_dropdown)
                        <div class="px-3 pt-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-t border-slate-100">
                            {!! $menu['nama'] !!}
                        </div>
                        @foreach ($menu['childrens'] as $child)
                            <a href="{{ $child['link_url'] }}" class="block px-5 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:text-[#0d6efd] hover:bg-slate-50">
                                <i class="fas fa-angle-right text-[10px] text-[#0d6efd] mr-2"></i> {!! $child['nama'] !!}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ $menu['link_url'] }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 text-[#2d3748]">
                            <i class="fas fa-circle text-[7px] text-[#0d6efd] mr-2.5"></i> {!! $menu['nama'] !!}
                        </a>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <!-- Footer Drawer -->
    <div class="p-4 border-t border-slate-200 bg-[#f8fafc] text-center text-xs text-slate-500 font-medium">
        Kec. Tinangkung Selatan, Banggai Kepulauan
    </div>
</div>
