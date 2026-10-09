@extends('theme::layouts.right-sidebar')

@php
    $isHome = empty($cari) && request()->segment(2) != 'kategori' && (request()->segment(2) !== 'index' && request()->segment(1) !== 'index');
    $title = !empty($judul_kategori) ? $judul_kategori : 'Kabar & Pengumuman Desa Terkini';
    if (is_array($title)) {
        $title = $title['kategori'] ?? 'Kabar Desa';
    }
@endphp

@if ($isHome)
    @section('top_showcase')
        @include('theme::partials.hero')
        @include('theme::partials.stats')
        @include('theme::partials.layanan')
    @endsection
@endif

@section('content')
    <div class="mb-6 pb-3 border-b border-slate-200 flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full mb-1">
                <i class="fas fa-newspaper"></i> Warta Berita
            </div>
            <h2 class="text-xl md:text-2xl font-black text-slate-900">{{ $title }}</h2>
        </div>
        <a href="{{ site_url('arsip') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
            Arsip Lengkap <i class="fas fa-chevron-right text-[10px]"></i>
        </a>
    </div>

    @if ($artikel->count() > 0)
        <div class="space-y-4">
            @foreach ($artikel as $post)
                @include('theme::partials.artikel.list', ['post' => $post])
            @endforeach
        </div>

        <div class="pt-6">
            @include('theme::commons.paging', ['paging_page' => $paging_page])
        </div>
    @else
        @include('theme::partials.artikel.empty', ['title' => $title])
    @endif
@endsection

@if ($isHome)
    @section('bottom_showcase')
        @include('theme::partials.apbdes_section')
        @include('theme::partials.pamong_section')
    @endsection
@endif
