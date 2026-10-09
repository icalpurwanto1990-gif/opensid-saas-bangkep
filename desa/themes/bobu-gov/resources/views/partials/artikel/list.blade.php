@php
    $url = $post->url_slug;
    $abstract = potong_teks(strip_tags($post['isi']), 220);
    $image = $post['gambar'] ? AmbilFotoArtikel($post['gambar'], 'sedang') : gambar_desa($desa['logo']);
    $kategori = $post['kategori'] ? ($post['category']['kategori'] ?? 'Kabar Desa') : 'Kabar Desa';
@endphp

<article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden mb-6 flex flex-col md:flex-row group">
    <!-- Thumbnail -->
    <a href="{{ $url }}" class="md:w-5/12 overflow-hidden relative block bg-slate-100 shrink-0">
        <img src="{{ $image }}" alt="{{ $post['judul'] }}"
             class="w-full h-48 md:h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
        <div class="absolute top-3 left-3">
            <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-emerald-600 text-white shadow-sm">
                {{ $kategori }}
            </span>
        </div>
    </a>

    <!-- Content Body -->
    <div class="p-5 md:w-7/12 flex flex-col justify-between space-y-3">
        <div class="space-y-2">
            <!-- Meta tags -->
            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                <span class="flex items-center gap-1.5">
                    <i class="far fa-calendar-alt text-amber-500"></i> {{ tgl_indo($post['tgl_upload']) }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="far fa-user text-emerald-600"></i> {{ $post['owner'] }}
                </span>
                @if (!empty($post['hit']))
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-eye text-blue-500"></i> {{ hit($post['hit']) }} x
                    </span>
                @endif
            </div>

            <!-- Title -->
            <h3 class="text-base md:text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                <a href="{{ $url }}">{{ $post['judul'] }}</a>
            </h3>

            <!-- Excerpt -->
            <p class="text-xs md:text-sm text-slate-600 line-clamp-3 leading-relaxed">
                {!! $abstract !!}
            </p>
        </div>

        <!-- Read More Action -->
        <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ $url }}" class="text-xs font-bold text-emerald-700 group-hover:text-emerald-800 flex items-center gap-1.5 transition">
                <span>Baca Selengkapnya</span>
                <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
            </a>
            @if ($post['dokumen'])
                <span class="text-[11px] text-blue-600 font-semibold flex items-center gap-1" title="Tersedia Dokumen Lampiran">
                    <i class="fas fa-paperclip"></i> Lampiran
                </span>
            @endif
        </div>
    </div>
</article>
