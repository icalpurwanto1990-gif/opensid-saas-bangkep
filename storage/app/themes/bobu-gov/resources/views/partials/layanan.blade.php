<section class="py-16 bg-white border-b border-slate-100">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-black bg-[#87de57] px-3.5 py-1.5 rounded-full mb-3">
                    <i class="fas fa-hand-holding-heart"></i> Layanan Cepat
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-black">Pusat Layanan Warga</h2>
                <p class="text-xs md:text-sm text-slate-600 mt-1.5">Akses mandiri permohonan surat administrasi, bantuan sosial, dan aspirasi 24 jam sehari.</p>
            </div>
            <a href="{{ site_url('layanan-mandiri') }}" class="text-xs font-bold text-[#029019] hover:text-black flex items-center gap-1.5">
                Semua Layanan Desa <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 6 Quick Service Grid (Desa Kersik Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Permohonan Surat Online -->
            <div class="kersik-service-card">
                <div>
                    <div class="kersik-service-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h3 class="kersik-service-title">Pengajuan Surat Online</h3>
                    <p class="kersik-service-desc">Permohonan Surat Keterangan Usaha, Domisili, Pengantar SKCK, Kematian & Kelahiran tanpa perlu antre di kantor desa.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-kersik-primary w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-pencil-alt text-xs"></i> Ajukan Surat Sekarang
                </a>
            </div>

            <!-- 2. Tracking Berkas Pengajuan -->
            <div class="kersik-service-card">
                <div>
                    <div class="kersik-service-icon">
                        <i class="fas fa-search-location"></i>
                    </div>
                    <h3 class="kersik-service-title">Cek Status Berkas</h3>
                    <p class="kersik-service-desc">Pantau progres penandatanganan dan verifikasi surat oleh Kepala Desa secara transparan dan akuntabel.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-kersik-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-check-circle text-xs"></i> Lacak Progres Berkas
                </a>
            </div>

            <!-- 3. Pengaduan & Aspirasi Warga -->
            <div class="kersik-service-card">
                <div>
                    <div class="kersik-service-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="kersik-service-title">Kanal Pengaduan Warga</h3>
                    <p class="kersik-service-desc">Sampaikan kritik, saran, permohonan informasi, dan laporan kerusakan fasilitas publik langsung ke aparat desa.</p>
                </div>
                <a href="{{ site_url('pengaduan') }}" class="btn-kersik-dark w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-paper-plane text-xs"></i> Tulis Laporan Anda
                </a>
            </div>

            <!-- 4. Transparansi Bantuan Sosial -->
            <div class="kersik-service-card">
                <div>
                    <div class="kersik-service-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="kersik-service-title">Cek Bantuan Sosial</h3>
                    <p class="kersik-service-desc">Keterbukaan data penerima manfaat BLT Dana Desa, PKH, BPNT, dan program bantuan sosial pemerintah lainnya.</p>
                </div>
                <a href="{{ site_url('bantuan') }}" class="btn-kersik-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-users text-xs"></i> Lihat Data Bantuan
                </a>
            </div>

            <!-- 5. Posyandu & Kesehatan Stunting -->
            <div class="kersik-service-card">
                <div>
                    <div class="kersik-service-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="kersik-service-title">Posyandu & Kesehatan</h3>
                    <p class="kersik-service-desc">Informasi jadwal penimbangan balita di posyandu desa, layanan lansia, serta program pencegahan stunting.</p>
                </div>
                <a href="{{ site_url('kesehatan') }}" class="btn-kersik-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-stethoscope text-xs"></i> Info Posyandu
                </a>
            </div>

            <!-- 6. Lapak UMKM & Potensi Pesisir -->
            <div class="kersik-service-card">
                <div>
                    <div class="kersik-service-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="kersik-service-title">Lapak UMKM Warga</h3>
                    <p class="kersik-service-desc">Katalog promosi produk olahan hasil laut, perikanan, pertanian, dan kerajinan tangan khas warga Desa Bobu.</p>
                </div>
                <a href="{{ site_url('lapak') }}" class="btn-kersik-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-shopping-basket text-xs"></i> Belanja Produk Lokal
                </a>
            </div>
        </div>
    </div>
</section>
