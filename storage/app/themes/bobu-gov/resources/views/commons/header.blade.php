@php
    $bg_header = $latar_website;
    $namaDesa = $desa['nama_desa'] ?? 'BOBU';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaProv = $desa['nama_propinsi'] ?? 'Sulawesi Tengah';
    $telepon = $desa['telepon'] ?? '0822-xxxx-xxxx';
    $emailDesa = $desa['email_desa'] ?? 'pemdes@bobu-tinangkungselatan.desa.id';
@endphp

<!-- 1. OFFICIAL GOV TOPBAR -->
<div class="gov-topbar py-2 px-3 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs">
            <span class="gov-badge-pulse">PORTAL SPBE RESMI</span>
            <span class="hidden sm:inline-flex items-center gap-1 text-slate-300">
                <i class="far fa-clock text-amber-400"></i> Jam Pelayanan: Senin - Jumat (08:00 - 15:30 WITA)
            </span>
            @if ($telepon)
                <a href="tel:{{ $telepon }}" class="inline-flex items-center gap-1 hover:text-amber-400">
                    <i class="fas fa-phone-alt text-emerald-400"></i> {{ $telepon }}
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4 text-xs">
            @if ($emailDesa)
                <a href="mailto:{{ $emailDesa }}" class="hidden lg:inline-flex items-center gap-1 hover:text-amber-400">
                    <i class="far fa-envelope text-blue-400"></i> {{ $emailDesa }}
                </a>
            @endif
            <div class="flex items-center gap-3">
                @if (!empty($sosmed))
                    @foreach ($sosmed as $social)
                        @if ($social['link'])
                            <a href="{{ $social['link'] }}" target="_blank" rel="noopener" class="hover:text-amber-400" title="{{ $social['nama'] }}">
                                <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }}"></i>
                            </a>
                        @endif
                    @endforeach
                @endif
                <a href="{{ site_url('siteman') }}" class="text-amber-400 hover:underline font-semibold ml-2">
                    <i class="fas fa-lock"></i> Login Aparatur
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 2. OFFICIAL BRAND & INSTITUTION HEADER -->
<header class="gov-brand-header px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Logo & Title -->
        <a href="{{ site_url('/') }}" class="flex items-center gap-4 text-center md:text-left group">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $namaDesa }}" class="gov-emblem-seal group-hover:scale-105 transition-transform duration-300">
            <div class="gov-brand-titles">
                <div class="gov-sup-title">Pemerintah Kabupaten {{ ucwords($namaKab) }}</div>
                <h1 class="gov-main-title">DESA {{ strtoupper($namaDesa) }}</h1>
                <div class="gov-sub-title">Kecamatan {{ ucwords($namaKec) }}, Provinsi {{ ucwords($namaProv) }}</div>
            </div>
        </a>

        <!-- Fast Action Direct Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-2">
            <a href="{{ site_url('layanan-mandiri') }}" class="btn-gov-primary">
                <i class="fas fa-id-card-alt text-lg"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider text-emerald-100">Layanan Warga</div>
                    <div class="text-xs font-bold">Layanan Mandiri (NIK)</div>
                </div>
            </a>
            <a href="{{ site_url('pengaduan') }}" class="btn-gov-gold">
                <i class="fas fa-bullhorn text-lg"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase tracking-wider text-amber-100">Aspirasi Online</div>
                    <div class="text-xs font-bold">Pengaduan Rakyat</div>
                </div>
            </a>
        </div>
    </div>
</header>

<!-- 3. OFFICIAL RUNNING TICKER / MAKLUMAT -->
@if ($teks_berjalan)
    <div class="gov-ticker-bar px-3 lg:px-8">
        <div class="container mx-auto flex items-center">
            <span class="gov-ticker-tag">
                <i class="fas fa-broadcast-tower animate-pulse"></i> Maklumat Resmi
            </span>
            <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="4" class="text-xs font-medium tracking-wide">
                @foreach ($teks_berjalan as $marquee)
                    <span class="inline-block mr-12 text-slate-100">
                        <i class="fas fa-chevron-right text-amber-400 mr-1 text-[10px]"></i>
                        {{ $marquee['teks'] }}
                        @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                            <a href="{{ $marquee['tautan'] }}" class="text-amber-300 underline font-semibold ml-1 hover:text-white">{{ $marquee['judul_tautan'] }}</a>
                        @endif
                    </span>
                @endforeach
            </marquee>
        </div>
    </div>
@endif

<!-- 4. OFFICIAL NAVIGATION BAR -->
<div class="gov-navbar-wrap">
    @include('theme::commons.main_menu')
</div>

<!-- Mobile Drawer Overlay -->
@include('theme::commons.mobile_menu')
