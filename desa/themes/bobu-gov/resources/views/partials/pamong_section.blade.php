@if (!empty($aparatur_desa['daftar_perangkat']) && is_array($aparatur_desa['daftar_perangkat']))
    <section class="py-12 bg-transparent">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#0d6efd] bg-blue-50 px-3.5 py-1.5 rounded-full mb-2.5 border border-blue-100">
                        <i class="fas fa-users-cog"></i> Jajaran Pamong
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-[#1a202c]">Aparatur Pemerintah Desa</h2>
                    <p class="text-xs md:text-sm text-slate-500 mt-1">Struktur organisasi dan jajaran pamong desa yang berdedikasi melayani segenap warga Desa Bobu.</p>
                </div>
                <a href="{{ site_url('pemerintah') }}" class="text-xs font-bold text-[#0d6efd] hover:text-[#0b5ed7] flex items-center gap-1.5">
                    Struktur Lengkap <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach (array_slice($aparatur_desa['daftar_perangkat'], 0, 6) as $pamong)
                    <div class="p-5 rounded-[20px] bg-white border border-slate-100 shadow-sm text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-200">
                        <img src="{{ $pamong['foto'] }}" alt="{{ $pamong['nama'] }}"
                             class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-2 border-blue-50 shadow-sm"
                             onerror="this.src='{{ base_url('assets/images/kuser.png') }}'">
                        <h4 class="text-xs font-extrabold text-[#1a202c] line-clamp-1 mb-1" title="{{ $pamong['nama'] }}">{{ $pamong['nama'] }}</h4>
                        <div class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold text-[#0d6efd] bg-blue-50 line-clamp-1 border border-blue-100" title="{{ $pamong['jabatan'] }}">
                            {{ $pamong['jabatan'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
