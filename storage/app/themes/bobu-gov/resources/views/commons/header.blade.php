@php
    $bg_header = $latar_website;
    $namaDesa = $desa['nama_desa'] ?? 'BOBU';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaProv = $desa['nama_propinsi'] ?? 'Sulawesi Tengah';
    $telepon = $desa['telepon'] ?? '0822-xxxx-xxxx';
    $emailDesa = $desa['email_desa'] ?? 'pemdes@bobu-tinangkungselatan.desa.id';
@endphp

<!-- 1. TOPBAR (Friendly Light Style - Desa Baka) -->
<div class="baka-topbar px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs">
            <span class="baka-badge-pill">
                <i class="fas fa-check-circle text-emerald-800"></i> DESA DIGITAL
            </span>
            <span class="hidden sm:inline-flex items-center gap-1.5 text-slate-600">
                <i class="far fa-clock text-amber-500"></i> Pelayanan: Senin - Jumat (08:00 - 15:30 WITA)
            </span>
            @if ($telepon)
                <a href="tel:{{ $telepon }}" class="inline-flex items-center gap-1 text-slate-700 hover:text-emerald-700">
                    <i class="fas fa-phone-alt text-emerald-600"></i> {{ $telepon }}
                </a>
            @endif
        </div>
        <div class="flex items-center gap-4 text-xs">
            @if ($emailDesa)
                <a href="mailto:{{ $emailDesa }}" class="hidden lg:inline-flex items-center gap-1 text-slate-600 hover:text-emerald-700">
                    <i class="far fa-envelope text-blue-500"></i> {{ $emailDesa }}
                </a>
            @endif
            <div class="flex items-center gap-3">
                @if (!empty($sosmed))
                    @foreach ($sosmed as $social)
                        @if ($social['link'])
                            <a href="{{ $social['link'] }}" target="_blank" rel="noopener" class="text-slate-500 hover:text-emerald-700" title="{{ $social['nama'] }}">
                                <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }}"></i>
                            </a>
                        @endif
                    @endforeach
                @endif
                <a href="{{ site_url('siteman') }}" class="text-emerald-700 hover:underline font-bold ml-2">
                    <i class="fas fa-user-lock"></i> Login Aparatur
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 2. BRANDING & LOGO HEADER -->
<header class="baka-brand-header px-4 lg:px-8">
    <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Logo & Village Name -->
        <a href="{{ site_url('/') }}" class="flex items-center gap-4 text-center md:text-left group">
            <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $namaDesa }}" class="w-16 h-16 object-contain group-hover:scale-105 transition-transform duration-300 drop-shadow-sm">
            <div>
                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Pemerintah Kabupaten {{ ucwords($namaKab) }}</div>
                <h1 class="baka-brand-title">DESA {{ strtoupper($namaDesa) }}</h1>
                <div class="baka-brand-subtitle">Kecamatan {{ ucwords($namaKec) }}, Provinsi {{ ucwords($namaProv) }}</div>
            </div>
        </a>

        <!-- Pill Action Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-2.5">
            <a href="{{ site_url('layanan-mandiri') }}" class="btn-pill-primary">
                <i class="fas fa-id-card"></i>
                <span>Layanan Mandiri Warga</span>
            </a>
            <a href="{{ site_url('pengaduan') }}" class="btn-pill-blue">
                <i class="fas fa-comment-dots"></i>
                <span>Pengaduan Online</span>
            </a>
        </div>
    </div>
</header>

<!-- 3. RUNNING TICKER PENGUMUMAN (Desa Baka Style: Fresh Green Pastel) -->
@if ($teks_berjalan)
    <div class="baka-ticker-bar px-4 lg:px-8">
        <div class="container mx-auto flex items-center">
            <span class="baka-ticker-tag">
                <i class="fas fa-bullhorn text-xs mr-1"></i> Informasi Desa
            </span>
            <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="4" class="text-xs font-semibold text-slate-700">
                @foreach ($teks_berjalan as $marquee)
                    <span class="inline-block mr-12">
                        <i class="fas fa-circle text-[6px] text-emerald-600 mr-1.5"></i>
                        {{ $marquee['teks'] }}
                        @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                            <a href="{{ $marquee['tautan'] }}" class="text-blue-600 underline font-bold ml-1.5 hover:text-emerald-700">{{ $marquee['judul_tautan'] }}</a>
                        @endif
                    </span>
                @endforeach
            </marquee>
        </div>
    </div>
@endif

<!-- 4. CLEAN & FRIENDLY NAVBAR -->
<div class="baka-navbar">
    @include('theme::commons.main_menu')
</div>

<!-- Mobile Drawer Overlay -->
@include('theme::commons.mobile_menu')
