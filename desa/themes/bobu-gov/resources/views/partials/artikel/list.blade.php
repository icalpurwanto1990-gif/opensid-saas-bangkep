@php
    $url = $post->url_slug;
    $abstract = potong_teks(strip_tags($post['isi']), 220);
    $image = $post['gambar'] ? AmbilFotoArtikel($post['gambar'], 'sedang') : gambar_desa($desa['logo']);
    $kategori = $post['kategori'] ? ($post['category']['kategori'] ?? 'Kabar Desa') : 'Kabar Desa';
@endphp

<article class="bg-white rounded-[20px] border border-slate-200/90 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.02),0_2px_4px_-1px_rgba(0,0,0,0.02)] hover:shadow-md transition-all duration-300 overflow-hidden mb-6 flex flex-col md:flex-row group">
    <!-- Thumbnail -->
    <a href="{{ $url }}" class="md:w-5/12 overflow-hidden relative block bg-slate-100 shrink-0">
        <img src="{{ $image }}" alt="{{ $post['judul'] }}"
             class="w-full h-48 md:h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
        <div class="absolute top-3.5 left-3.5">
            <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#f5d042] text-[#2d3748] shadow-sm">
                {{ $kategori }}
            </span>
        </div>
    </a>

    <!-- Content Body -->
    <div class="p-6 md:w-7/12 flex flex-col justify-between space-y-3">
        <div class="space-y-2">
            <!-- Meta tags -->
            <div class="flex flex-wrap items-center gap-3 text-xs text-[#666666]">
                <span class="flex items-center gap-1.5">
                    <i class="far fa-calendar-alt text-[#2b7a0b]"></i> {{ tgl_indo($post['tgl_upload']) }}
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="far fa-user text-[#0d6efd]"></i> {{ $post['owner'] }}
                </span>
                @if (!empty($post['hit']))
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-eye text-slate-400"></i> {{ hit($post['hit']) }} x
                    </span>
                @endif
            </div>

            <!-- Title -->
            <h3 class="text-base md:text-lg font-bold text-[#2d3748] group-hover:text-[#2b7a0b] transition-colors line-clamp-2 leading-snug">
                <a href="{{ $url }}">{{ $post['judul'] }}</a>
            </h3>

            <!-- Excerpt -->
            <p class="text-xs md:text-sm text-[#666666] line-clamp-3 leading-relaxed">
                {!! $abstract !!}
            </p>
        </div>

        <!-- Read More Action -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ $url }}" class="text-xs font-bold text-[#2b7a0b] group-hover:text-[#236509] flex items-center gap-1.5 transition">
                <span>Baca Selengkapnya</span>
                <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
            </a>
            @if ($post['dokumen'])
                <span class="text-[11px] text-[#0d6efd] font-semibold flex items-center gap-1" title="Tersedia Dokumen Lampiran">
                    <i class="fas fa-paperclip"></i> Lampiran
                </span>
            @endif
        </div>
    </div>
</article>
