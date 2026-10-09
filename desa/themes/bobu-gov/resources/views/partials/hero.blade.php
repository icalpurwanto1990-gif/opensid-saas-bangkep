@php
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $kades = $desa['nama_kades'] ?? 'Ilyas M. Tadja';
@endphp

<section class="baka-hero-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Left: Hero Headline (Desa Baka Style) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="baka-hero-pill-badge">
                    <i class="fas fa-seedling"></i>
                    <span>DESA DIGITAL BOBU</span>
                </div>

                <h1 class="baka-hero-title">
                    DESA <span>{{ strtoupper($namaDesa) }}</span>
                </h1>

                <p class="baka-hero-desc">
                    Mewujudkan ekosistem desa digital yang transparan, inovatif, dan berdaya saing di wilayah Kecamatan {{ ucwords($namaKec) }}, Kabupaten {{ ucwords($namaKab) }}.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ site_url('layanan-mandiri') }}" class="btn-pill-primary">
                        <i class="fas fa-file-signature"></i>
                        <span>Ajukan Permohonan Surat</span>
                    </a>
                    <a href="{{ site_url('layanan-mandiri') }}" class="btn-pill-blue">
                        <i class="fas fa-id-card"></i>
                        <span>Layanan Mandiri Warga</span>
                    </a>
                    <a href="{{ site_url('pengaduan') }}" class="btn-pill-outline">
                        <i class="fas fa-comment-dots"></i>
                        <span>Pengaduan Online</span>
                    </a>
                </div>
            </div>

            <!-- Right: Kades Greeting Card (Rounded 20px Baka Card) -->
            <div class="lg:col-span-5">
                <div class="card-baka bg-white border border-slate-200">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="relative shrink-0">
                            <div class="w-16 h-16 rounded-full bg-emerald-100 border-2 border-emerald-600 flex items-center justify-center text-2xl text-emerald-800 overflow-hidden shadow-sm">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <span class="absolute bottom-0 right-0 w-5 h-5 rounded-full bg-emerald-600 border-2 border-white flex items-center justify-center text-[9px] text-white" title="Kepala Desa Aktif">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Kepala Desa {{ ucwords($namaDesa) }}</div>
                            <h3 class="text-lg font-extrabold text-[#2d3748]">{{ $kades }}</h3>
                            <div class="text-xs text-slate-500">Masa Bakti Aktif 2026</div>
                        </div>
                    </div>

                    <p class="text-xs md:text-sm text-[#666666] leading-relaxed italic border-l-4 border-emerald-500 pl-3 py-1 mb-4">
                        "Selamat datang di portal informasi resmi Desa Bobu. Melalui digitalisasi desa, kami hadirkan pelayanan publik yang cepat, mudah diakses, dan transparan untuk seluruh masyarakat."
                    </p>

                    <div class="p-3 rounded-2xl bg-[#f4fbf1] border border-[#dcf2d4] flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 text-slate-700">
                            <i class="fab fa-whatsapp text-emerald-600 text-lg"></i>
                            <div>
                                <div class="font-bold text-[#2d3748]">Hotline WhatsApp Desa</div>
                                <div class="text-[11px] text-slate-500">{{ $telepon }}</div>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $telepon) }}" target="_blank" rel="noopener" class="btn-pill-primary !py-1.5 !px-3 !text-xs">
                            Hubungi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
