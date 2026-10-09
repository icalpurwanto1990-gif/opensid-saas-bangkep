@php
    $url = $post->url_slug;
    $abstract = potong_teks(strip_tags($post['isi']), 200);
    $image = $post['gambar'] ? AmbilFotoArtikel($post['gambar'], 'sedang') : gambar_desa($desa['logo']);
    $kategori = $post['kategori'] ? ($post['category']['kategori'] ?? 'Kabar Desa') : 'Kabar Desa';
@endphp

<article class="bg-white rounded-[20px] border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden mb-5 flex flex-col md:flex-row group hover:-translate-y-0.5">
    <!-- Thumbnail -->
    <a href="{{ $url }}" class="md:w-5/12 overflow-hidden relative block bg-[#f8fafc] shrink-0">
        <img src="{{ $image }}" alt="{{ $post['judul'] }}"
             class="w-full h-48 md:h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
        <div class="absolute top-3.5 left-3.5">
            <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#0d6efd] text-white shadow-sm">
                {{ $kategori }}
            </span>
        </div>
    </a>

    <!-- Content Body -->
    <div class="p-6 md:w-7/12 flex flex-col justify-between space-y-3">
        <div class="space-y-2">
            <!-- Meta tags -->
            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                <span class="flex items-center gap-1.5 font-medium">
                    <i class="far fa-calendar-alt text-[#0d6efd]"></i> {{ tgl_indo($post['tgl_upload']) }}
                </span>
                <span class="flex items-center gap-1.5 font-medium">
                    <i class="far fa-user text-slate-400"></i> {{ $post['owner'] }}
                </span>
                @if (!empty($post['hit']))
                    <span class="flex items-center gap-1.5 font-medium">
                        <i class="far fa-eye text-slate-400"></i> {{ hit($post['hit']) }} x
                    </span>
                @endif
            </div>

            <!-- Title (Plus Jakarta Sans 800) -->
            <h3 class="text-base md:text-lg font-extrabold text-[#1a202c] group-hover:text-[#0d6efd] transition-colors line-clamp-2 leading-snug">
                <a href="{{ $url }}">{{ $post['judul'] }}</a>
            </h3>

            <!-- Excerpt -->
            <p class="text-xs md:text-sm text-slate-600 line-clamp-3 leading-relaxed">
                {!! $abstract !!}
            </p>
        </div>

        <!-- Read More Action -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ $url }}" class="text-xs font-bold text-[#0d6efd] group-hover:text-[#0b5ed7] flex items-center gap-1.5 transition">
                <span>Baca Selengkapnya</span>
                <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
            </a>
            @if ($post['dokumen'])
                <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1" title="Tersedia Dokumen Lampiran">
                    <i class="fas fa-paperclip"></i> Lampiran
                </span>
            @endif
        </div>
    </div>
</article>
