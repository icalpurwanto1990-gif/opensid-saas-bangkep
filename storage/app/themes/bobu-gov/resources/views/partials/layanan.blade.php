<section class="py-14 bg-transparent">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-800 bg-[#e8f5e9] px-3.5 py-1.5 rounded-full mb-2.5">
                    <i class="fas fa-hand-holding-heart"></i> Citizen Services
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#2d3748]">Pusat Layanan Cepat Warga</h2>
                <p class="text-xs md:text-sm text-[#666666] mt-1.5">Kemudahan akses permohonan surat administrasi, bantuan sosial, dan aspirasi 24 jam sehari.</p>
            </div>
            <a href="{{ site_url('layanan-mandiri') }}" class="text-xs font-bold text-[#0d6efd] hover:text-emerald-700 flex items-center gap-1.5">
                Semua Layanan Desa <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 6 Quick Service Grid (Rounded 20px Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Permohonan Surat Online -->
            <div class="baka-service-card">
                <div>
                    <div class="baka-service-icon bg-[#e8f5e9] text-[#2b7a0b]">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3 class="baka-service-title">Pengajuan Surat Online</h3>
                    <p class="baka-service-desc">Permohonan Surat Keterangan Usaha, Domisili, Pengantar SKCK, Kematian & Kelahiran tanpa perlu antre di kantor desa.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-pill-primary w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-pencil-alt text-xs"></i> Ajukan Surat Sekarang
                </a>
            </div>

            <!-- 2. Tracking Berkas Pengajuan -->
            <div class="baka-service-card">
                <div>
                    <div class="baka-service-icon bg-[#e7f1ff] text-[#0d6efd]">
                        <i class="fas fa-search-location"></i>
                    </div>
                    <h3 class="baka-service-title">Cek Status Berkas</h3>
                    <p class="baka-service-desc">Pantau progres penandatanganan dan verifikasi surat oleh Kepala Desa secara transparan dan akuntabel.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-pill-blue w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-check-circle text-xs"></i> Lacak Progres Berkas
                </a>
            </div>

            <!-- 3. Pengaduan & Aspirasi Warga -->
            <div class="baka-service-card">
                <div>
                    <div class="baka-service-icon bg-[#fef9c3] text-[#ca8a04]">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="baka-service-title">Kanal Pengaduan Warga</h3>
                    <p class="baka-service-desc">Sampaikan kritik, saran, permohonan informasi, dan laporan kerusakan fasilitas publik langsung ke aparat desa.</p>
                </div>
                <a href="{{ site_url('pengaduan') }}" class="btn-pill-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-paper-plane text-xs"></i> Tulis Laporan Anda
                </a>
            </div>

            <!-- 4. Transparansi Bantuan Sosial -->
            <div class="baka-service-card">
                <div>
                    <div class="baka-service-icon bg-[#f3e8ff] text-[#7e22ce]">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="baka-service-title">Cek Bantuan Sosial</h3>
                    <p class="baka-service-desc">Keterbukaan data penerima manfaat BLT Dana Desa, PKH, BPNT, dan bantuan sosial pemerintah lainnya.</p>
                </div>
                <a href="{{ site_url('bantuan') }}" class="btn-pill-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-users text-xs"></i> Lihat Daftar Penerima
                </a>
            </div>

            <!-- 5. Posyandu & Kesehatan Stunting -->
            <div class="baka-service-card">
                <div>
                    <div class="baka-service-icon bg-[#ffe4e6] text-[#e11d48]">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="baka-service-title">Posyandu & Kesehatan</h3>
                    <p class="baka-service-desc">Informasi jadwal penimbangan balita di posyandu desa, layanan lansia, serta program pencegahan stunting.</p>
                </div>
                <a href="{{ site_url('kesehatan') }}" class="btn-pill-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-stethoscope text-xs"></i> Info Jadwal Posyandu
                </a>
            </div>

            <!-- 6. Lapak UMKM & Potensi Pesisir -->
            <div class="baka-service-card">
                <div>
                    <div class="baka-service-icon bg-[#ccfbf1] text-[#0f766e]">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="baka-service-title">Lapak UMKM Warga</h3>
                    <p class="baka-service-desc">Katalog promosi produk olahan hasil laut, perikanan, pertanian, dan kerajinan tangan khas warga Desa Bobu.</p>
                </div>
                <a href="{{ site_url('lapak') }}" class="btn-pill-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-shopping-basket text-xs"></i> Belanja Produk Lokal
                </a>
            </div>
        </div>
    </div>
</section>
