@php
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaProv = $desa['nama_propinsi'] ?? 'Sulawesi Tengah';
    $alamatKantor = $desa['kantor_desa'] ?? 'Jl. Trans Pesisir Bobu, Kec. Tinangkung Selatan';
    $telepon = $desa['telepon'] ?? '';
    $emailDesa = $desa['email_desa'] ?? '';
    $kodepos = $desa['kode_pos'] ?? '94885';
@endphp

@include('theme::commons.back_to_top')

<footer class="bobu-footer">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- 1. Identitas Desa & Visi -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo" class="w-12 h-12 object-contain brightness-110">
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pemerintah Desa</div>
                        <div class="text-xl font-extrabold text-white tracking-wide">{{ strtoupper($namaDesa) }}</div>
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Portal Informasi & Pelayanan Digital Resmi Desa {{ ucwords($namaDesa) }}, Kecamatan {{ ucwords($namaKec) }}, Kabupaten {{ ucwords($namaKab) }}. Mewujudkan tata kelola desa yang transparan, inovatif, dan berdaya saing.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#2d3748] text-[#0d6efd] text-xs font-bold border border-slate-700">
                        <i class="fas fa-check-circle text-[#10b981]"></i> Portal Pelayanan Terpadu
                    </span>
                </div>
            </div>

            <!-- 2. Kantor & Pelayanan -->
            <div>
                <h4>Kantor & Jam Pelayanan</h4>
                <ul class="space-y-3 text-xs text-slate-300">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-[#0d6efd] mt-1 shrink-0"></i>
                        <span>{{ $alamatKantor }}, Kode Pos {{ $kodepos }}</span>
                    </li>
                    @if ($telepon)
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-phone-alt text-[#10b981] shrink-0"></i>
                            <a href="tel:{{ $telepon }}" class="hover:text-white">{{ $telepon }}</a>
                        </li>
                    @endif
                    @if ($emailDesa)
                        <li class="flex items-center gap-2.5">
                            <i class="far fa-envelope text-[#0d6efd] shrink-0"></i>
                            <a href="mailto:{{ $emailDesa }}" class="hover:text-white">{{ $emailDesa }}</a>
                        </li>
                    @endif
                    <li class="flex items-start gap-2.5 pt-1">
                        <i class="far fa-clock text-[#10b981] mt-1 shrink-0"></i>
                        <div>
                            <div class="font-bold text-white">Jam Kerja Kantor Desa:</div>
                            <div class="text-slate-400">Senin - Kamis : 08:00 - 15:30 WITA</div>
                            <div class="text-slate-400">Jumat : 08:00 - 11:30 WITA</div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- 3. Tautan Terkait -->
            <div>
                <h4>Tautan Penting</h4>
                <ul class="space-y-2.5 text-xs text-slate-300">
                    <li>
                        <a href="https://bangkepkab.go.id" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#0d6efd]">
                            <i class="fas fa-angle-right text-[#0d6efd]"></i> Pemkab Banggai Kepulauan
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('diskominfo') }}" class="flex items-center gap-2 hover:text-[#0d6efd]">
                            <i class="fas fa-angle-right text-[#0d6efd]"></i> Diskominfo Bangkep
                        </a>
                    </li>
                    <li>
                        <a href="https://kemendesa.go.id" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#0d6efd]">
                            <i class="fas fa-angle-right text-[#0d6efd]"></i> Kementerian Desa PDTT
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('layanan-mandiri') }}" class="flex items-center gap-2 hover:text-[#0d6efd]">
                            <i class="fas fa-id-card text-[#10b981]"></i> Masuk Layanan Mandiri
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('pengaduan') }}" class="flex items-center gap-2 hover:text-[#0d6efd]">
                            <i class="fas fa-comment-dots text-[#10b981]"></i> Pengaduan Warga
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('lapak') }}" class="flex items-center gap-2 hover:text-[#0d6efd]">
                            <i class="fas fa-store text-[#0d6efd]"></i> Lapak UMKM Desa
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 4. Media Sosial & Akuntabilitas -->
            <div>
                <h4>Saluran Informasi</h4>
                <p class="text-xs text-slate-300 mb-3 leading-relaxed">
                    Ikuti perkembangan kegiatan pembangunan dan pengumuman resmi Desa Bobu melalui kanal media sosial resmi:
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                    @if (!empty($sosmed))
                        @foreach ($sosmed as $social)
                            @if ($social['link'])
                                <a href="{{ $social['link'] }}" target="_blank" rel="noopener"
                                   class="w-9 h-9 rounded-full bg-[#2d3748] border border-slate-700 flex items-center justify-center text-slate-300 hover:text-white hover:bg-[#0d6efd] transition-colors"
                                   title="{{ $social['nama'] }}">
                                    <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }} text-xs"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="p-3.5 rounded-[16px] bg-[#2d3748] border border-slate-700 text-[11px] text-slate-300">
                    <div class="font-bold text-[#10b981] mb-1"><i class="fas fa-shield-alt mr-1"></i> Transparansi Publik</div>
                    Masyarakat berhak mendapatkan informasi publik desa secara transparan dan akuntabel sesuai amanat UU No. 6 Tahun 2014 tentang Desa.
                </div>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="bobu-footer-bottom flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                &copy; {{ date('Y') }} Pemerintah Desa {{ ucwords($namaDesa) }}. Hak cipta dilindungi undang-undang.
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span>Tema: <strong class="text-white">Desa Bobu Government</strong></span>
                <span class="text-slate-600">|</span>
                <span>Didukung oleh <strong class="text-[#0d6efd]">OpenSID SaaS & Diskominfo Bangkep</strong></span>
            </div>
        </div>
    </div>
</footer>
