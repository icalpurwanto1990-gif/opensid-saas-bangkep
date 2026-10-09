@php
    $bg_header = $latar_website;
    $namaDesa = $desa['nama_desa'] ?? 'BOBU';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaProv = $desa['nama_propinsi'] ?? 'Sulawesi Tengah';
    $telepon = $desa['telepon'] ?? '';
    $emailDesa = $desa['email_desa'] ?? '';
@endphp

<!-- 1. TOPBAR (Desa Kersik Style: Crisp Surface #f6f6f6) -->
<div class="kersik-topbar px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs">
            <span class="kersik-badge-lime">
                <i class="fas fa-check-circle"></i> PORTAL RESMI DESA
            </span>
            <span class="hidden sm:inline-flex items-center gap-1.5 text-slate-700 font-medium">
                <i class="far fa-clock text-slate-500"></i> Pelayanan Kantor: Senin - Jumat (08:00 - 15:30 WITA)
            </span>
            @if ($telepon)
                <a href="tel:{{ $telepon }}" class="inline-flex items-center gap-1 text-slate-800 font-semibold hover:text-[#029019]">
                    <i class="fas fa-phone-alt text-[#029019]"></i> {{ $telepon }}
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4 text-xs">
            @if ($emailDesa)
                <a href="mailto:{{ $emailDesa }}" class="hidden lg:inline-flex items-center gap-1 text-slate-700 hover:text-[#029019]">
                    <i class="far fa-envelope text-slate-500"></i> {{ $emailDesa }}
                </a>
            @endif
            <div class="flex items-center gap-3">
                @if (!empty($sosmed))
                    @foreach ($sosmed as $social)
                        @if ($social['link'])
                            <a href="{{ $social['link'] }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-black" title="{{ $social['nama'] }}">
                                <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }}"></i>
                            </a>
                        @endif
                    @endforeach
                @endif
                <a href="{{ site_url('siteman') }}" class="text-black hover:text-[#029019] font-bold ml-2">
                    <i class="fas fa-user-lock"></i> Login Aparatur
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 2. BRANDING & LOGO HEADER -->
<header class="kersik-brand-header px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Logo & Village Name -->
        <a href="{{ site_url('/') }}" class="flex items-center gap-4 text-center md:text-left group">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $namaDesa }}" class="w-16 h-16 object-contain group-hover:scale-105 transition-transform duration-300">
            <div>
                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pemerintah Kabupaten {{ ucwords($namaKab) }}</div>
                <h1 class="kersik-brand-title">DESA {{ strtoupper($namaDesa) }}</h1>
                <div class="kersik-brand-subtitle">Kecamatan {{ ucwords($namaKec) }}, Provinsi {{ ucwords($namaProv) }}</div>
            </div>
        </a>

        <!-- Action Buttons (Desa Kersik Pill Standard) -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ site_url('layanan-mandiri') }}" class="btn-kersik-primary">
                <i class="fas fa-id-card"></i>
                <span>Layanan Mandiri Warga</span>
            </a>
            <a href="{{ site_url('pengaduan') }}" class="btn-kersik-outline">
                <i class="fas fa-comment-dots"></i>
                <span>Pengaduan Online</span>
            </a>
        </div>
    </div>
</header>

<!-- 3. RUNNING TICKER PENGUMUMAN (Desa Kersik Style) -->
@if ($teks_berjalan)
    <div class="kersik-ticker-bar px-4 lg:px-8">
        <div class="container mx-auto flex items-center">
            <span class="kersik-ticker-tag">
                <i class="fas fa-bullhorn text-xs mr-1"></i> Pengumuman
            </span>
            <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="4" class="text-xs font-semibold text-slate-800">
                @foreach ($teks_berjalan as $marquee)
                    <span class="inline-block mr-12">
                        <i class="fas fa-circle text-[6px] text-[#029019] mr-1.5"></i>
                        {{ $marquee['teks'] }}
                        @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                            <a href="{{ $marquee['tautan'] }}" class="text-[#029019] underline font-bold ml-1.5 hover:text-black">{{ $marquee['judul_tautan'] }}</a>
                        @endif
                    </span>
                @endforeach
            </marquee>
        </div>
    </div>
@endif

<!-- 4. CLEAN & ENERGETIC NAVBAR -->
<div class="kersik-navbar">
    @include('theme::commons.main_menu')
</div>

<!-- Mobile Drawer Overlay -->
@include('theme::commons.mobile_menu')
