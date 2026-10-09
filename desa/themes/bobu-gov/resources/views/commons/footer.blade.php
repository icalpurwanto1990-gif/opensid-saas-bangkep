@php
    $namaDesa = $desa['nama_desa'] ?? 'Bobu';
    $namaKec = $desa['nama_kecamatan'] ?? 'Tinangkung Selatan';
    $namaKab = $desa['nama_kabupaten'] ?? 'Banggai Kepulauan';
    $namaProv = $desa['nama_propinsi'] ?? 'Sulawesi Tengah';
    $alamatKantor = $desa['kantor_desa'] ?? 'Jl. Trans Pesisir Bobu, Kec. Tinangkung Selatan';
    $telepon = $desa['telepon'] ?? '0822-xxxx-xxxx';
    $emailDesa = $desa['email_desa'] ?? 'pemdes@bobu-tinangkungselatan.desa.id';
    $kodepos = $desa['kode_pos'] ?? '94885';
@endphp

@include('theme::commons.back_to_top')

<footer class="gov-footer mt-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- 1. Identitas Resmi & Visi -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo" class="w-12 h-12 object-contain brightness-110">
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pemerintah Desa</div>
                        <div class="text-xl font-black text-white tracking-wide">{{ strtoupper($namaDesa) }}</div>
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Portal Resmi Pemerintah Desa {{ ucwords($namaDesa) }}, Kecamatan {{ ucwords($namaKec) }}, Kabupaten {{ ucwords($namaKab) }}. Berkomitmen mewujudkan tata kelola pemerintahan yang transparan, akuntabel, dan melayani masyarakat secara prima melalui pemanfaatan Sistem Pemerintahan Berbasis Elektronik (SPBE).
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-950/80 border border-emerald-600/40 text-emerald-400 text-xs font-semibold">
                        <i class="fas fa-shield-alt"></i> Terverifikasi SPBE Bangkep
                    </span>
                </div>
            </div>

            <!-- 2. Kantor & Kontak Resmi -->
            <div>
                <h4>Kantor & Kontak</h4>
                <ul class="space-y-3 text-xs text-slate-300">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-amber-400 mt-1 shrink-0"></i>
                        <span>{{ $alamatKantor }}, Kode Pos {{ $kodepos }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-phone-alt text-emerald-400 shrink-0"></i>
                        <span>{{ $telepon }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="far fa-envelope text-blue-400 shrink-0"></i>
                        <span>{{ $emailDesa }}</span>
                    </li>
                    <li class="flex items-start gap-2.5 pt-1">
                        <i class="far fa-clock text-amber-400 mt-1 shrink-0"></i>
                        <div>
                            <div class="font-semibold text-slate-200">Jam Pelayanan Kantor:</div>
                            <div class="text-slate-400">Senin - Kamis : 08:00 - 15:30 WITA</div>
                            <div class="text-slate-400">Jumat : 08:00 - 11:30 WITA</div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- 3. Tautan Instansi Terkait -->
            <div>
                <h4>Portal Terkait</h4>
                <ul class="space-y-2.5 text-xs text-slate-300">
                    <li>
                        <a href="https://bangkepkab.go.id" target="_blank" rel="noopener" class="hover:text-emerald-400 flex items-center gap-2">
                            <i class="fas fa-external-link-alt text-[10px] text-slate-500"></i> Pemkab Banggai Kepulauan
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('diskominfo') }}" class="hover:text-emerald-400 flex items-center gap-2">
                            <i class="fas fa-satellite-dish text-[10px] text-slate-500"></i> Diskominfo Command Center
                        </a>
                    </li>
                    <li>
                        <a href="https://kemendesa.go.id" target="_blank" rel="noopener" class="hover:text-emerald-400 flex items-center gap-2">
                            <i class="fas fa-external-link-alt text-[10px] text-slate-500"></i> Kementerian Desa PDTT
                        </a>
                    </li>
                    <li>
                        <a href="https://kemendagri.go.id" target="_blank" rel="noopener" class="hover:text-emerald-400 flex items-center gap-2">
                            <i class="fas fa-external-link-alt text-[10px] text-slate-500"></i> Kementerian Dalam Negeri RI
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('layanan-mandiri') }}" class="hover:text-emerald-400 flex items-center gap-2">
                            <i class="fas fa-id-card text-[10px] text-emerald-400"></i> Portal Layanan Mandiri Warga
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 4. Media Sosial & Akuntabilitas -->
            <div>
                <h4>Saluran Informasi</h4>
                <p class="text-xs text-slate-400 mb-3">
                    Ikuti perkembangan kegiatan pembangunan dan pengumuman resmi Desa Bobu melalui media sosial resmi:
                </p>
                <div class="flex flex-wrap gap-2 mb-4">
                    @if (!empty($sosmed))
                        @foreach ($sosmed as $social)
                            @if ($social['link'])
                                <a href="{{ $social['link'] }}" target="_blank" rel="noopener"
                                   class="w-9 h-9 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 hover:text-white hover:bg-emerald-600 transition-colors"
                                   title="{{ $social['nama'] }}">
                                    <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }} text-sm"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="p-3 rounded-xl bg-slate-900 border border-slate-800 text-[11px] text-slate-400">
                    <div class="font-bold text-slate-200 mb-1"><i class="fas fa-bullhorn text-amber-400 mr-1"></i> Keterbukaan Informasi</div>
                    Masyarakat berhak mendapatkan informasi publik desa sesuai UU No. 14 Tahun 2008 & UU No. 6 Tahun 2014 tentang Desa.
                </div>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="gov-footer-bottom flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                &copy; {{ date('Y') }} Pemerintah Desa {{ ucwords($namaDesa) }}. Hak Cipta Dilindungi Undang-Undang.
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span>Tema: <strong class="text-slate-300">Bobu Modern Government</strong></span>
                <span class="text-slate-600">|</span>
                <span>Didukung oleh <strong class="text-emerald-400">OpenSID & Diskominfo Bangkep</strong></span>
            </div>
        </div>
    </div>
</footer>
