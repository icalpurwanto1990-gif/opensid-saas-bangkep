<!-- Backdrop Overlay -->
<div id="govMobileOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden transition-opacity"></div>

<!-- Slide-out Drawer Menu (Desa Kersik Style) -->
<div id="govMobileDrawer" class="fixed inset-y-0 left-0 w-80 max-w-[85vw] bg-white text-black z-50 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col shadow-2xl font-['Outfit']">
    <!-- Header Drawer -->
    <div class="p-5 bg-[#f6f6f6] border-b border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo" class="w-10 h-10 object-contain">
            <div>
                <div class="text-[10px] font-bold text-slate-500 uppercase">PEMERINTAH DESA</div>
                <div class="text-base font-extrabold text-black">BOBU</div>
            </div>
        </div>
        <button id="govMobileCloseBtn" type="button" class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-slate-700 hover:text-red-600 shadow-sm">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>

    <!-- Mobile Search Form -->
    <div class="p-4 border-b border-slate-100 bg-white">
        <form action="{{ site_url('/') }}" method="get" class="relative">
            <input type="text" name="cari" placeholder="Cari layanan, berita..."
                   class="w-full bg-[#f6f6f6] text-black text-xs rounded-full pl-9 pr-4 py-2.5 border border-slate-200 focus:outline-none focus:border-[#87de57]">
            <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
        </form>
    </div>

    <!-- Quick Action Links -->
    <div class="p-4 grid grid-cols-2 gap-2 border-b border-slate-100 bg-white">
        <a href="{{ site_url('layanan-mandiri') }}" class="p-2.5 rounded-full bg-[#87de57] text-black text-xs font-bold text-center hover:bg-[#6bd731] transition">
            <i class="fas fa-id-card"></i> Mandiri NIK
        </a>
        <a href="{{ site_url('pengaduan') }}" class="p-2.5 rounded-full bg-black text-white text-xs font-bold text-center hover:bg-slate-800 transition">
            <i class="fas fa-comment-dots"></i> Pengaduan
        </a>
    </div>

    <!-- Navigation Tree -->
    <div class="flex-1 overflow-y-auto p-4 space-y-1">
        <a href="{{ site_url('/') }}" class="block px-4 py-2.5 rounded-xl text-sm font-bold bg-[#87de57] text-black">
            <i class="fas fa-home mr-2.5"></i> Beranda Utama
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
                            <a href="{{ $child['link_url'] }}" class="block px-5 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:text-black hover:bg-[#f6f6f6]">
                                <i class="fas fa-angle-right text-[10px] text-[#029019] mr-2"></i> {!! $child['nama'] !!}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ $menu['link_url'] }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#f6f6f6] text-black">
                            <i class="fas fa-circle text-[7px] text-[#029019] mr-2.5"></i> {!! $menu['nama'] !!}
                        </a>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <!-- Footer Drawer -->
    <div class="p-4 border-t border-slate-100 bg-[#f6f6f6] text-center text-[11px] text-slate-500">
        <div>Kec. Tinangkung Selatan, Bangkep</div>
        <div class="text-[10px] text-slate-400 mt-1">&copy; {{ date('Y') }} Pemerintah Desa Bobu</div>
    </div>
</div>
