@php
    $bg_header = $latar_website;
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaProv = $desa['nama_propinsi'] ?? 'Sulawesi Tengah';
    $telepon = $desa['telepon'] ?? '';
    $emailDesa = $desa['email_desa'] ?? '';
@endphp

<!-- 1. TOPBAR INFORMASI RESMI & JAM KERJA -->
<div class="bobu-topbar px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-[#0d6efd] font-bold border border-blue-100">
                <i class="fas fa-shield-alt text-[#0d6efd]"></i> PORTAL RESMI DESA
            </span>
            <span class="hidden sm:inline-flex items-center gap-1.5 text-slate-600 font-medium">
                <i class="far fa-clock text-[#0d6efd]"></i> Pelayanan: Senin - Jumat (08:00 - 15:30 WITA)
            </span>
            @if ($telepon)
                <a href="tel:{{ $telepon }}" class="inline-flex items-center gap-1.5 text-slate-700 font-semibold hover:text-[#0d6efd]">
                    <i class="fas fa-phone-alt text-[#10b981]"></i> {{ $telepon }}
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4 text-xs">
            @if ($emailDesa)
                <a href="mailto:{{ $emailDesa }}" class="hidden lg:inline-flex items-center gap-1 text-slate-600 hover:text-[#0d6efd]">
                    <i class="far fa-envelope text-slate-400"></i> {{ $emailDesa }}
                </a>
            @endif
            <div class="flex items-center gap-3">
                @if (!empty($sosmed))
                    @foreach ($sosmed as $social)
                        @if ($social['link'])
                            <a href="{{ $social['link'] }}" target="_blank" rel="noopener" class="text-slate-500 hover:text-[#0d6efd]" title="{{ $social['nama'] }}">
                                <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }}"></i>
                            </a>
                        @endif
                    @endforeach
                @endif
                <a href="{{ site_url('siteman') }}" class="text-[#2d3748] hover:text-[#0d6efd] font-bold ml-2 inline-flex items-center gap-1.5">
                    <i class="fas fa-user-lock text-slate-400"></i> Login Aparatur
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 2. BRANDING & LOGO HEADER -->
<header class="bobu-brand-header px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Logo & Village Official Name -->
        <a href="{{ site_url('/') }}" class="flex items-center gap-4 text-center md:text-left group">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $namaDesa }}" class="w-16 h-16 object-contain group-hover:scale-105 transition-transform duration-300">
            <div>
                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pemerintah Kabupaten {{ ucwords($namaKab) }}</div>
                <h1 class="bobu-brand-title">Pemerintah Desa {{ ucwords($namaDesa) }}</h1>
                <div class="bobu-brand-subtitle">Kec. {{ ucwords($namaKec) }}, Kab. {{ ucwords($namaKab) }}</div>
            </div>
        </a>

        <!-- Capsule Action Buttons (Layanan Mandiri & Pengaduan) -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ site_url('layanan-mandiri') }}" class="btn-bobu-primary">
                <i class="fas fa-id-card"></i>
                <span>Layanan Mandiri Warga</span>
            </a>
            <a href="{{ site_url('pengaduan') }}" class="btn-bobu-outline">
                <i class="fas fa-comment-dots"></i>
                <span>Pengaduan Online</span>
            </a>
            <a href="{{ site_url('lapak') }}" class="btn-bobu-green">
                <i class="fas fa-store"></i>
                <span>Lapak UMKM</span>
            </a>
        </div>
    </div>
</header>

<!-- 3. RUNNING TICKER PENGUMUMAN (MARQUEE) -->
@if ($teks_berjalan)
    <div class="bobu-ticker-bar px-4 lg:px-8">
        <div class="container mx-auto flex items-center">
            <span class="bobu-ticker-tag">
                <i class="fas fa-bullhorn text-xs mr-1"></i> Informasi Terkini
            </span>
            <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="4" class="text-xs font-semibold text-[#2d3748]">
                @foreach ($teks_berjalan as $marquee)
                    <span class="inline-block mr-12">
                        <i class="fas fa-circle text-[6px] text-[#0d6efd] mr-1.5"></i>
                        {{ $marquee['teks'] }}
                        @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                            <a href="{{ $marquee['tautan'] }}" class="text-[#0d6efd] underline font-bold ml-1.5 hover:text-black">{{ $marquee['judul_tautan'] }}</a>
                        @endif
                    </span>
                @endforeach
            </marquee>
        </div>
    </div>
@endif

<!-- 4. CLEAN STICKY NAVBAR -->
<div class="bobu-navbar">
    @include('theme::commons.main_menu')
</div>

<!-- Mobile Drawer Overlay -->
@include('theme::commons.mobile_menu')
