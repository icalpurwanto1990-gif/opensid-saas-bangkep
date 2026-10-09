@php
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaKades = $desa['nama_kades'] ?? '';
    $telepon = $desa['telepon'] ?? '';
@endphp

<section class="bobu-hero-section">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Left: Hero Headline (Plus Jakarta Sans 800) -->
            <div class="lg:col-span-7 space-y-5">
                <div class="bobu-hero-badge">
                    <i class="fas fa-landmark text-[#0d6efd]"></i>
                    <span>PORTAL RESMI PEMERINTAH DESA</span>
                </div>

                <h1 class="bobu-hero-title">
                    Portal Resmi <span>Desa {{ ucwords($namaDesa) }}</span>
                </h1>

                <p class="bobu-hero-desc">
                    Mewujudkan ekosistem desa digital yang transparan, inovatif, dan berdaya saing di wilayah Kecamatan {{ ucwords($namaKec) }}, Kabupaten {{ ucwords($namaKab) }}. Akses langsung permohonan surat kependudukan, transparansi anggaran, warta pembangunan, dan pengaduan warga.
                </p>

                <!-- Action Buttons (Capsule/Pill Style) -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ site_url('layanan-mandiri') }}" class="btn-bobu-primary">
                        <i class="fas fa-id-card"></i>
                        <span>Layanan Surat Mandiri</span>
                    </a>
                    <a href="{{ site_url('pengaduan') }}" class="btn-bobu-green">
                        <i class="fas fa-comment-dots"></i>
                        <span>Pengaduan Warga</span>
                    </a>
                    <a href="{{ site_url('artikel/kategori/profil-desa') }}" class="btn-bobu-outline">
                        <i class="fas fa-compass"></i>
                        <span>Jelajahi Potensi Desa</span>
                    </a>
                </div>
            </div>

            <!-- Right: Hero Visual Card (Rounded 20px) -->
            <div class="lg:col-span-5">
                <div class="card-bobu bg-white">
                    <div class="relative rounded-[16px] overflow-hidden mb-5 bg-[#f8fafc] border border-slate-100 aspect-[16/10] flex items-center justify-center shadow-inner">
                        @if (!empty($latar_website) && is_file(FCPATH . $latar_website))
                            <img src="{{ base_url($latar_website) }}" alt="Desa {{ $namaDesa }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-6 space-y-2">
                                <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $namaDesa }}" class="w-20 h-20 mx-auto object-contain drop-shadow">
                                <div class="font-extrabold text-lg text-[#1a202c]">Pemerintah Desa {{ ucwords($namaDesa) }}</div>
                                <div class="text-xs text-slate-500 font-medium">Kec. {{ ucwords($namaKec) }}, Kab. {{ ucwords($namaKab) }}</div>
                            </div>
                        @endif
                    </div>

                    @if (!empty($namaKades))
                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-[#0d6efd] flex items-center justify-center text-base font-bold shadow-sm">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kepala Desa {{ ucwords($namaDesa) }}</div>
                                <div class="text-sm font-extrabold text-[#1a202c]">{{ $namaKades }}</div>
                            </div>
                        </div>
                    @endif

                    @if (!empty($telepon))
                        <div class="pt-3 flex items-center justify-between text-xs">
                            <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                <i class="fab fa-whatsapp text-[#10b981] text-sm"></i> Layanan WhatsApp Kantor:
                            </span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $telepon) }}" target="_blank" rel="noopener" class="font-bold text-[#0d6efd] hover:underline">
                                {{ $telepon }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
