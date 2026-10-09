<section class="py-12 bg-transparent">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full mb-2">
                    <i class="fas fa-hand-holding-heart"></i> Citizen-Centric Services
                </div>
                <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900">Pusat Layanan Cepat Warga</h3>
                <p class="text-xs md:text-sm text-slate-600 mt-1">Kemudahan akses permohonan surat administrasi, bantuan sosial, dan aspirasi 24 jam sehari.</p>
            </div>
            <a href="{{ site_url('layanan-mandiri') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                Buka Semua Layanan <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 6 Quick Service Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Permohonan Surat Online -->
            <div class="gov-service-card">
                <div>
                    <div class="gov-service-icon bg-emerald-100 text-emerald-700">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h4 class="gov-service-title">Pengajuan Surat Online</h4>
                    <p class="gov-service-desc">Permohonan Surat Keterangan Usaha, Domisili, Pengantar SKCK, Kematian & Kelahiran tanpa perlu antre di kantor desa.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-gov-primary w-full justify-center text-xs py-2">
                    <i class="fas fa-pencil-alt text-xs"></i> Ajukan Surat Sekarang
                </a>
            </div>

            <!-- 2. Tracking Berkas Pengajuan -->
            <div class="gov-service-card">
                <div>
                    <div class="gov-service-icon bg-blue-100 text-blue-700">
                        <i class="fas fa-search-location"></i>
                    </div>
                    <h4 class="gov-service-title">Cek Status Permohonan</h4>
                    <p class="gov-service-desc">Pantau progres penandatanganan dan verifikasi surat oleh Kepala Desa secara transparan dan akuntabel.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="px-4 py-2 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-600 hover:text-white transition font-semibold text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-check-circle text-xs"></i> Lacak Progres Berkas
                </a>
            </div>

            <!-- 3. Pengaduan & Aspirasi Warga -->
            <div class="gov-service-card">
                <div>
                    <div class="gov-service-icon bg-amber-100 text-amber-700">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h4 class="gov-service-title">Kanal Pengaduan Rakyat</h4>
                    <p class="gov-service-desc">Sampaikan kritik, saran, permohonan informasi, dan laporan kerusakan fasilitas publik langsung ke aparat desa.</p>
                </div>
                <a href="{{ site_url('pengaduan') }}" class="px-4 py-2 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-600 hover:text-white transition font-semibold text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i> Tulis Laporan Anda
                </a>
            </div>

            <!-- 4. Transparansi Bantuan Sosial -->
            <div class="gov-service-card">
                <div>
                    <div class="gov-service-icon bg-purple-100 text-purple-700">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h4 class="gov-service-title">Cek Bantuan Sosial (Bansos)</h4>
                    <p class="gov-service-desc">Keterbukaan data penerima manfaat BLT Dana Desa, PKH, BPNT, dan bantuan sosial pemerintah lainnya.</p>
                </div>
                <a href="{{ site_url('bantuan') }}" class="px-4 py-2 rounded-lg bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-600 hover:text-white transition font-semibold text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-users text-xs"></i> Lihat Daftar Penerima
                </a>
            </div>

            <!-- 5. Posyandu & Kesehatan Stunting -->
            <div class="gov-service-card">
                <div>
                    <div class="gov-service-icon bg-rose-100 text-rose-700">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h4 class="gov-service-title">Posyandu & Kesehatan Warga</h4>
                    <p class="gov-service-desc">Informasi jadwal penimbangan balita di posyandu desa, layanan lansia, serta program pencegahan stunting.</p>
                </div>
                <a href="{{ site_url('kesehatan') }}" class="px-4 py-2 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-600 hover:text-white transition font-semibold text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-stethoscope text-xs"></i> Info Jadwal Posyandu
                </a>
            </div>

            <!-- 6. Lapak UMKM & Potensi Pesisir -->
            <div class="gov-service-card">
                <div>
                    <div class="gov-service-icon bg-teal-100 text-teal-700">
                        <i class="fas fa-store"></i>
                    </div>
                    <h4 class="gov-service-title">Lapak UMKM Desa Bobu</h4>
                    <p class="gov-service-desc">Katalog promosi produk olahan hasil laut, perikanan, pertanian, dan kerajinan tangan khas warga Desa Bobu.</p>
                </div>
                <a href="{{ site_url('lapak') }}" class="px-4 py-2 rounded-lg bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-600 hover:text-white transition font-semibold text-xs flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-basket text-xs"></i> Belanja Produk Lokal
                </a>
            </div>
        </div>
    </div>
</section>
