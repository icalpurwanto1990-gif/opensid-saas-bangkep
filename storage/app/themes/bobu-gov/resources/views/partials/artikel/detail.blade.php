@extends('theme::layouts.' . $layout)
@php
    $post = $single_artikel;
    $alt_slug = PREMIUM ? 'artikel' : 'first';
@endphp
@include('theme::commons.asset_highcharts')

@section('content')
    @if ($post)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 lg:p-8">
            <!-- Breadcrumbs -->
            <nav role="navigation" aria-label="navigation" class="mb-4 text-xs text-slate-500">
                <ol class="flex items-center gap-2">
                    <li><a href="{{ ci_route() }}" class="hover:text-emerald-600"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><i class="fas fa-chevron-right text-[9px] text-slate-400"></i></li>
                    <li>
                        @if ($post['kategori'])
                            <a href="{{ ci_route("{$alt_slug}.kategori.{$post['kat_slug']}") }}" class="hover:text-emerald-600 font-semibold text-emerald-700">
                                {{ $post['kategori'] }}
                            </a>
                        @else
                            <span class="text-slate-400">Warta Desa</span>
                        @endif
                    </li>
                </ol>
            </nav>

            <!-- Article Header -->
            <header class="mb-6 pb-4 border-b border-slate-100">
                <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-900 leading-tight mb-4">
                    {{ $post['judul'] }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                    <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                        <i class="far fa-user text-emerald-600"></i> {{ $post['owner'] }}
                        <i class="fas fa-check-circle text-emerald-500 text-[10px]" title="Penulis Resmi Terverifikasi"></i>
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="far fa-calendar-alt text-amber-500"></i> {{ $post['tgl_upload_local'] ?? tgl_indo($post['tgl_upload']) }}
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="far fa-eye text-blue-500"></i> {{ hit($post['hit']) }} x dibaca
                    </span>
                </div>
            </header>

            <!-- Main Feature Image -->
            @if ($post['gambar'])
                <div class="mb-6 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                    <a href="{{ AmbilFotoArtikel($post['gambar'], 'sedang') }}" data-fancybox="images">
                        <img src="{{ AmbilFotoArtikel($post['gambar'], 'sedang') }}" alt="{{ $post['judul'] }}" class="w-full h-auto max-h-[500px] object-cover">
                    </a>
                </div>
            @endif

            <!-- Article Content -->
            <div class="prose prose-slate max-w-none text-slate-700 text-sm md:text-base leading-relaxed space-y-4">
                {!! $post['isi'] !!}
            </div>

            <!-- Additional Images Gallery -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-6">
                @for ($i = 1; $i <= 3; $i++)
                    @if ($post['gambar' . $i])
                        <a href="{{ AmbilFotoArtikel($post['gambar' . $i], 'sedang') }}" class="rounded-xl overflow-hidden border border-slate-200 block shadow-sm" data-fancybox="images">
                            <img src="{{ AmbilFotoArtikel($post['gambar' . $i], 'sedang') }}" alt="{{ $post['nama'] ?? 'Foto' }}" class="w-full h-40 object-cover hover:scale-105 transition-transform duration-300">
                        </a>
                    @endif
                @endfor
            </div>

            <!-- Attached Document Download -->
            @if ($post['dokumen'])
                <div class="my-6 p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-blue-900">Dokumen Lampiran Resmi</div>
                            <div class="text-xs text-blue-700 font-medium truncate max-w-xs md:max-w-md">{{ $post['dokumen'] }}</div>
                        </div>
                    </div>
                    <a href="{{ ci_route('first.unduh_dokumen_artikel', $post['id']) }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center gap-2 transition">
                        <i class="fas fa-download"></i> Unduh
                    </a>
                </div>
            @endif

            <!-- Social Share & Comments -->
            <div class="pt-6 border-t border-slate-200">
                @include('theme::commons.share')
                @include('theme::partials.artikel.comment')
            </div>
        </div>
    @else
        @include('theme::commons.404')
    @endif
@endsection
