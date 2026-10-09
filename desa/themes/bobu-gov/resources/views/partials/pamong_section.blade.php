@if (!empty($aparatur_desa['daftar_perangkat']) && is_array($aparatur_desa['daftar_perangkat']))
    <section class="py-14 bg-transparent">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-purple-800 bg-[#f3e8ff] px-3.5 py-1.5 rounded-full mb-2.5">
                        <i class="fas fa-users-cog"></i> Jajaran Pamong
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-[#2d3748]">Aparatur Pemerintah Desa Bobu</h2>
                    <p class="text-xs md:text-sm text-[#666666] mt-1.5">Struktur organisasi dan jajaran pamong desa yang berdedikasi melayani segenap warga.</p>
                </div>
                <a href="{{ site_url('pemerintah') }}" class="text-xs font-bold text-[#0d6efd] hover:text-blue-800 flex items-center gap-1.5">
                    Struktur Lengkap <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach (array_slice($aparatur_desa['daftar_perangkat'], 0, 6) as $pamong)
                    <div class="p-5 rounded-[20px] bg-white border border-slate-200/90 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.02)] text-center transition-all hover:-translate-y-1 hover:shadow-md">
                        <img src="{{ $pamong['foto'] }}" alt="{{ $pamong['nama'] }}"
                             class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-2 border-slate-100 shadow-sm"
                             onerror="this.src='{{ base_url('assets/images/kuser.png') }}'">
                        <h4 class="text-xs font-extrabold text-[#2d3748] line-clamp-1 mb-1" title="{{ $pamong['nama'] }}">{{ $pamong['nama'] }}</h4>
                        <div class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold text-[#2b7a0b] bg-[#e8f5e9] line-clamp-1" title="{{ $pamong['jabatan'] }}">
                            {{ $pamong['jabatan'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
