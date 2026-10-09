@if (!empty($aparatur_desa['daftar_perangkat']) && is_array($aparatur_desa['daftar_perangkat']))
    <section class="py-12 bg-transparent">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-purple-700 bg-purple-100 px-3 py-1 rounded-full mb-2">
                        <i class="fas fa-users-cog"></i> Jajaran Kepengurusan
                    </div>
                    <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900">Aparatur Pemerintah Desa Bobu</h3>
                    <p class="text-xs md:text-sm text-slate-600 mt-1">Struktur organisasi dan jajaran pamong desa yang berdedikasi melayani segenap warga.</p>
                </div>
                <a href="{{ site_url('pemerintah') }}" class="text-xs font-bold text-purple-700 hover:text-purple-800 flex items-center gap-1">
                    Lihat Struktur Lengkap <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach (array_slice($aparatur_desa['daftar_perangkat'], 0, 6) as $pamong)
                    <div class="gov-pamong-card">
                        <img src="{{ $pamong['foto'] }}" alt="{{ $pamong['nama'] }}" class="gov-pamong-img" onerror="this.src='{{ base_url('assets/images/kuser.png') }}'">
                        <h4 class="gov-pamong-name line-clamp-1" title="{{ $pamong['nama'] }}">{{ $pamong['nama'] }}</h4>
                        <div class="gov-pamong-role line-clamp-1" title="{{ $pamong['jabatan'] }}">{{ $pamong['jabatan'] }}</div>
                        @if (!empty($pamong['pamong_niap']))
                            <div class="text-[10px] text-slate-400 mt-1">NIAP: {{ $pamong['pamong_niap'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
