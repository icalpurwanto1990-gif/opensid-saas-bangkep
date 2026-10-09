@php
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaKades = $desa['nama_kades'] ?? '';
    $telepon = $desa['telepon'] ?? '';
@endphp

<section class="kersik-hero-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Left: Hero Headline (Desa Kersik Standard Pattern) -->
            <div class="lg:col-span-7 space-y-5">
                <div class="kersik-hero-lead-tag">
                    <i class="fas fa-compass text-[#029019]"></i>
                    <span>PORTAL EKSPLORASI DIGITAL</span>
                </div>

                <h1 class="kersik-hero-title">
                    JELAJAHI <span>Desa {{ ucwords($namaDesa) }}</span>
                </h1>

                <p class="kersik-hero-desc">
                    Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa {{ ucwords($namaDesa) }}: aspek pemerintahan, penduduk, demografi, potensi desa, dan berita terkini di Kecamatan {{ ucwords($namaKec) }}, Kabupaten {{ ucwords($namaKab) }}.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ site_url('layanan-mandiri') }}" class="btn-kersik-primary">
                        <i class="fas fa-id-card"></i>
                        <span>Layanan Mandiri Warga</span>
                    </a>
                    <a href="{{ site_url('artikel/kategori/profil-desa') }}" class="btn-kersik-outline">
                        <i class="fas fa-info-circle"></i>
                        <span>Profil Desa</span>
                    </a>
                    <a href="{{ site_url('pengaduan') }}" class="btn-kersik-dark">
                        <i class="fas fa-comment-dots"></i>
                        <span>Kirim Aspirasi</span>
                    </a>
                </div>
            </div>

            <!-- Right: Hero Visual Card (Desa Kersik 16px Card) -->
            <div class="lg:col-span-5">
                <div class="card-kersik bg-white">
                    <div class="relative rounded-[12px] overflow-hidden mb-5 bg-[#f6f6f6] border border-slate-200 aspect-[16/10] flex items-center justify-center">
                        @if (!empty($latar_website) && is_file(FCPATH . $latar_website))
                            <img src="{{ base_url($latar_website) }}" alt="Desa {{ $namaDesa }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-6 space-y-2">
                                <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo" class="w-20 h-20 mx-auto object-contain">
                                <div class="font-bold text-lg text-black">Desa {{ ucwords($namaDesa) }}</div>
                                <div class="text-xs text-slate-500">Kec. {{ ucwords($namaKec) }}</div>
                            </div>
                        @endif
                    </div>

                    @if (!empty($namaKades))
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-full bg-[#f0fdf4] text-[#029019] flex items-center justify-center text-lg font-bold">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase text-slate-500">Kepala Desa {{ ucwords($namaDesa) }}</div>
                                <div class="text-sm font-extrabold text-black">{{ $namaKades }}</div>
                            </div>
                        </div>
                    @endif

                    @if (!empty($telepon))
                        <div class="pt-3 flex items-center justify-between text-xs">
                            <span class="text-slate-600 font-medium">
                                <i class="fab fa-whatsapp text-[#029019] mr-1"></i> Kontak Kantor Desa:
                            </span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $telepon) }}" target="_blank" rel="noopener" class="font-bold text-black hover:text-[#029019] underline">
                                {{ $telepon }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
