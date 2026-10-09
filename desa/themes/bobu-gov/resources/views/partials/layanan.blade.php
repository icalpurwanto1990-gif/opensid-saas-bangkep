<section class="py-12 bg-transparent">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#0d6efd] bg-blue-50 px-3.5 py-1.5 rounded-full mb-2.5 border border-blue-100">
                    <i class="fas fa-hand-holding-heart"></i> Administrasi & Pelayanan Warga
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#1a202c]">Pusat Layanan Terpadu Desa</h2>
                <p class="text-xs md:text-sm text-slate-500 mt-1">Kemudahan akses mandiri permohonan surat, lapak UMKM, penyampaian aspirasi, dan informasi program desa.</p>
            </div>
            <a href="{{ site_url('layanan-mandiri') }}" class="text-xs font-bold text-[#0d6efd] hover:text-[#0b5ed7] flex items-center gap-1.5">
                Semua Layanan Desa <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 6 Interactive Service Cards (Rounded 20px, Pill Buttons) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Permohonan Surat Online (Layanan Mandiri) -->
            <div class="bobu-service-card">
                <div>
                    <div class="bobu-service-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h3 class="bobu-service-title">Layanan Surat Mandiri</h3>
                    <p class="bobu-service-desc">Permohonan Surat Keterangan Usaha, Domisili, Pengantar SKCK, Kelahiran & Kematian secara online menggunakan PIN Warga.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-bobu-primary w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-id-card text-xs"></i> Masuk Layanan Mandiri
                </a>
            </div>

            <!-- 2. Pengaduan & Aspirasi Masyarakat -->
            <div class="bobu-service-card">
                <div>
                    <div class="bobu-service-icon" style="background-color: #ecfdf5; color: #10b981;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="bobu-service-title">Pengaduan Masyarakat</h3>
                    <p class="bobu-service-desc">Kanal resmi penyampaian aspirasi, kritik konstruktif, pengaduan pelayanan, dan laporan fasilitas publik langsung ke pamong desa.</p>
                </div>
                <a href="{{ site_url('pengaduan') }}" class="btn-bobu-green w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-paper-plane text-xs"></i> Kirim Laporan Aspirasi
                </a>
            </div>

            <!-- 3. Lapak Produk UMKM Warga -->
            <div class="bobu-service-card">
                <div>
                    <div class="bobu-service-icon" style="background-color: #fffbeb; color: #f59e0b;">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="bobu-service-title">Lapak Produk UMKM</h3>
                    <p class="bobu-service-desc">Etalase digital pemasaran produk lokal olahan hasil laut, perikanan, pertanian, dan kerajinan tangan khas warga Desa Bobu.</p>
                </div>
                <a href="{{ site_url('lapak') }}" class="btn-bobu-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-shopping-basket text-xs"></i> Jelajahi Produk Warga
                </a>
            </div>

            <!-- 4. Lacak Progres Berkas Layanan -->
            <div class="bobu-service-card">
                <div>
                    <div class="bobu-service-icon" style="background-color: #f5f3ff; color: #8b5cf6;">
                        <i class="fas fa-search-location"></i>
                    </div>
                    <h3 class="bobu-service-title">Lacak Dokumen Surat</h3>
                    <p class="bobu-service-desc">Pantau status verifikasi dan penandatanganan dokumen administrasi Anda secara real-time dan transparan.</p>
                </div>
                <a href="{{ site_url('layanan-mandiri') }}" class="btn-bobu-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-check-circle text-xs"></i> Cek Status Berkas
                </a>
            </div>

            <!-- 5. Transparansi Bantuan Sosial -->
            <div class="bobu-service-card">
                <div>
                    <div class="bobu-service-icon" style="background-color: #fdf2f8; color: #ec4899;">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="bobu-service-title">Cek Program Bantuan</h3>
                    <p class="bobu-service-desc">Keterbukaan informasi penerima manfaat program bantuan sosial (BLT Dana Desa, PKH, BPNT) di Desa Bobu.</p>
                </div>
                <a href="{{ site_url('bantuan') }}" class="btn-bobu-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-users text-xs"></i> Informasi Bantuan Sosial
                </a>
            </div>

            <!-- 6. Peta Wilayah & Potensi Desa -->
            <div class="bobu-service-card">
                <div>
                    <div class="bobu-service-icon" style="background-color: #ecfeff; color: #06b6d4;">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="bobu-service-title">Peta Wilayah & Geografis</h3>
                    <p class="bobu-service-desc">Eksplorasi batas wilayah administratif dusun, sarana umum, fasilitas kesehatan, dan letak kantor desa secara interaktif.</p>
                </div>
                <a href="{{ site_url('peta') }}" class="btn-bobu-outline w-full justify-center !text-xs !py-2.5">
                    <i class="fas fa-globe text-xs"></i> Buka Peta Interaktif
                </a>
            </div>
        </div>
    </div>
</section>
