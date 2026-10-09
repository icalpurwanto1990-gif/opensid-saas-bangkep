@php
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $kades = $desa['nama_kades'] ?? 'Ilyas M. Tadja';
@endphp

<section class="gov-hero-section relative">
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Left: Hero Headline & Welcome -->
            <div class="lg:col-span-7 space-y-5">
                <div class="gov-hero-pill">
                    <i class="fas fa-certificate text-amber-400"></i>
                    <span>Portal Resmi Pemerintah Desa Berbasis SPBE</span>
                </div>

                <h2 class="gov-hero-title">
                    Mewujudkan Pelayanan Publik <span>Modern, Cepat & Terbuka</span> di Desa {{ ucwords($namaDesa) }}
                </h2>

                <p class="gov-hero-desc">
                    Selamat datang di situs resmi Pemerintah Desa {{ ucwords($namaDesa) }}, Kecamatan {{ ucwords($namaKec) }}, Kabupaten {{ ucwords($namaKab) }}. Akses informasi publik, ajukan surat permohonan secara mandiri, dan pantau pembangunan desa secara transparan dari mana saja.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ site_url('layanan-mandiri') }}" class="btn-gov-primary px-5 py-3 text-sm">
                        <i class="fas fa-file-signature text-lg"></i>
                        <span>Buat Permohonan Surat</span>
                    </a>
                    <a href="{{ site_url('pengaduan') }}" class="px-5 py-3 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-white text-sm font-semibold border border-slate-600 transition flex items-center gap-2">
                        <i class="fas fa-comment-dots text-amber-400"></i>
                        <span>Kirim Aspirasi & Pengaduan</span>
                    </a>
                </div>
            </div>

            <!-- Right: Kades Official Greeting Card -->
            <div class="lg:col-span-5">
                <div class="gov-kades-card">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 rounded-full bg-slate-800 border-2 border-amber-400 flex items-center justify-center text-3xl text-amber-300 overflow-hidden shadow-lg">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <span class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-emerald-500 border-2 border-slate-900 flex items-center justify-center text-[10px] text-white" title="Aktif Menjabat">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>

                    <div class="space-y-1">
                        <div class="text-[10px] uppercase tracking-wider font-bold text-amber-300">Kepala Desa {{ ucwords($namaDesa) }}</div>
                        <h3 class="text-base font-extrabold text-white">{{ $kades }}</h3>
                        <p class="text-xs text-slate-300 italic line-clamp-3">
                            "Kami berkomitmen melayani warga Bobu dengan hati, mengedepankan keterbukaan informasi, dan menghadirkan kemudahan pelayanan melalui teknologi."
                        </p>
                    </div>
                </div>

                <!-- Emergency Contact Quick Box -->
                <div class="mt-4 p-3.5 rounded-xl bg-slate-900/60 border border-slate-700/60 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2.5 text-slate-300">
                        <i class="fas fa-headset text-emerald-400 text-base"></i>
                        <div>
                            <div class="font-bold text-white">Butuh Bantuan Cepat?</div>
                            <div class="text-[11px] text-slate-400">Hubungi Hotline Pelayanan Kantor Desa</div>
                        </div>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $desa['telepon'] ?? '6282200000000') }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] flex items-center gap-1.5 transition">
                        <i class="fab fa-whatsapp"></i> Hubungi WA
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
