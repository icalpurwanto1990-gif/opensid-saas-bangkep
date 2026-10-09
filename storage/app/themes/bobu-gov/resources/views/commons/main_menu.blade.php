<div class="container mx-auto px-4 lg:px-8">
    <div class="flex items-center justify-between">
        <!-- Desktop Nav Items -->
        <nav class="hidden lg:flex items-center space-x-1 py-1" role="navigation">
            <!-- Home Link -->
            <a href="{{ site_url('/') }}" class="kersik-nav-link {{ request()->is('/') ? 'active' : '' }}" title="Beranda Utama">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>

            <!-- Dynamic OpenSID Menus -->
            @if (menu_tema())
                @foreach (menu_tema() as $menu)
                    @php $has_dropdown = count($menu['childrens'] ?? []) > 0 @endphp
                    <div class="relative group">
                        <a href="{{ $has_dropdown ? '#!' : $menu['link_url'] }}"
                           class="kersik-nav-link flex items-center gap-1.5 cursor-pointer">
                            <span>{!! $menu['nama'] !!}</span>
                            @if ($has_dropdown)
                                <i class="fas fa-chevron-down text-[10px] text-slate-500 group-hover:text-black transition-transform duration-200 group-hover:rotate-180"></i>
                            @endif
                        </a>

                        @if ($has_dropdown)
                            <!-- Dropdown Level 1 -->
                            <div class="absolute left-0 top-full pt-1 hidden group-hover:block z-50 min-w-[230px]">
                                <div class="bg-white border border-slate-200 rounded-[16px] shadow-xl py-2 overflow-hidden">
                                    @foreach ($menu['childrens'] as $child)
                                        @php $child_has_dropdown = count($child['childrens'] ?? []) > 0 @endphp
                                        <div class="relative group/sub">
                                            <a href="{{ $child_has_dropdown ? '#!' : $child['link_url'] }}"
                                               class="flex items-center justify-between px-5 py-2.5 text-xs font-bold text-slate-800 hover:text-black hover:bg-[#87de57] transition-colors">
                                                <span>{!! $child['nama'] !!}</span>
                                                @if ($child_has_dropdown)
                                                    <i class="fas fa-chevron-right text-[9px] text-slate-400"></i>
                                                @endif
                                            </a>

                                            @if ($child_has_dropdown)
                                                <!-- Dropdown Level 2 -->
                                                <div class="absolute left-full top-0 pl-1 hidden group-hover/sub:block z-50 min-w-[210px]">
                                                    <div class="bg-white border border-slate-200 rounded-[16px] shadow-xl py-2 overflow-hidden">
                                                        @foreach ($child['childrens'] as $grandchild)
                                                            <a href="{{ $grandchild['link_url'] }}"
                                                               class="block px-5 py-2 text-xs font-bold text-slate-800 hover:text-black hover:bg-[#87de57] transition-colors">
                                                                {!! $grandchild['nama'] !!}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </nav>

        <!-- Right: Pill Search Box -->
        <div class="hidden lg:block py-2">
            <form action="{{ site_url('/') }}" method="get" class="relative flex items-center">
                <input type="text" name="cari" value="{{ request('cari') }}"
                       placeholder="Cari berita, informasi..."
                       class="bg-[#f6f6f6] text-black placeholder-slate-400 text-xs rounded-full pl-9 pr-4 py-2.5 w-60 border border-slate-300 focus:outline-none focus:border-[#87de57] focus:bg-white transition-all font-medium">
                <i class="fas fa-search absolute left-3.5 text-slate-400 text-xs"></i>
            </form>
        </div>

        <!-- Mobile Toggle Button -->
        <div class="lg:hidden flex items-center justify-between w-full py-3">
            <a href="{{ site_url('/') }}" class="text-black text-sm font-bold flex items-center gap-2">
                <i class="fas fa-landmark text-[#029019]"></i> Desa Bobu
            </a>
            <button id="govMobileMenuBtn" type="button" class="text-black bg-[#87de57] hover:bg-[#6bd731] px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 shadow-sm transition">
                <i class="fas fa-bars"></i>
                <span>Menu</span>
            </button>
        </div>
    </div>
</div>
