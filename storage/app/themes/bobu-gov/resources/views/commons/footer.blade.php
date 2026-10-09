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

<footer class="kersik-footer">
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
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#2a2a2a] text-[#87de57] text-xs font-bold border border-slate-700">
                        <i class="fas fa-check-circle"></i> Portal Eksplorasi Digital
                    </span>
                </div>
            </div>

            <!-- 2. Kantor & Pelayanan -->
            <div>
                <h4>Kantor & Kontak</h4>
                <ul class="space-y-3 text-xs text-slate-300">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-[#87de57] mt-1 shrink-0"></i>
                        <span>{{ $alamatKantor }}, Kode Pos {{ $kodepos }}</span>
                    </li>
                    @if ($telepon)
                        <li class="flex items-center gap-2.5">
                            <i class="fas fa-phone-alt text-[#87de57] shrink-0"></i>
                            <span>{{ $telepon }}</span>
                        </li>
                    @endif
                    @if ($emailDesa)
                        <li class="flex items-center gap-2.5">
                            <i class="far fa-envelope text-[#87de57] shrink-0"></i>
                            <span>{{ $emailDesa }}</span>
                        </li>
                    @endif
                    <li class="flex items-start gap-2.5 pt-1">
                        <i class="far fa-clock text-[#87de57] mt-1 shrink-0"></i>
                        <div>
                            <div class="font-bold text-white">Jam Pelayanan Kantor:</div>
                            <div class="text-slate-400">Senin - Kamis : 08:00 - 15:30 WITA</div>
                            <div class="text-slate-400">Jumat : 08:00 - 11:30 WITA</div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- 3. Tautan Terkait -->
            <div>
                <h4>Portal Terkait</h4>
                <ul class="space-y-2.5 text-xs text-slate-300">
                    <li>
                        <a href="https://bangkepkab.go.id" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#87de57]">
                            <i class="fas fa-angle-right text-[#87de57]"></i> Pemkab Banggai Kepulauan
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('diskominfo') }}" class="flex items-center gap-2 hover:text-[#87de57]">
                            <i class="fas fa-angle-right text-[#87de57]"></i> Diskominfo Command Center
                        </a>
                    </li>
                    <li>
                        <a href="https://kemendesa.go.id" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#87de57]">
                            <i class="fas fa-angle-right text-[#87de57]"></i> Kementerian Desa PDTT
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('layanan-mandiri') }}" class="flex items-center gap-2 hover:text-[#87de57]">
                            <i class="fas fa-id-card text-[#87de57]"></i> Layanan Mandiri NIK
                        </a>
                    </li>
                    <li>
                        <a href="{{ site_url('pengaduan') }}" class="flex items-center gap-2 hover:text-[#87de57]">
                            <i class="fas fa-comment-dots text-[#87de57]"></i> Pengaduan Warga
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
                                   class="w-9 h-9 rounded-full bg-[#2a2a2a] border border-slate-700 flex items-center justify-center text-slate-300 hover:text-black hover:bg-[#87de57] transition-colors"
                                   title="{{ $social['nama'] }}">
                                    <i class="fab fa-{{ strtolower($social['nama']) == 'facebook' ? 'facebook-f' : strtolower($social['nama']) }} text-xs"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="p-3.5 rounded-[12px] bg-[#2a2a2a] border border-slate-700 text-[11px] text-slate-300">
                    <div class="font-bold text-[#87de57] mb-1"><i class="fas fa-shield-alt mr-1"></i> Transparansi Publik</div>
                    Masyarakat berhak mendapatkan informasi publik desa secara transparan dan akuntabel sesuai amanat UU No. 6 Tahun 2014.
                </div>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="kersik-footer-bottom flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                &copy; {{ date('Y') }} Pemerintah Desa {{ ucwords($namaDesa) }}. Seluruh hak cipta dilindungi.
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span>Tema: <strong class="text-white">Desa Bobu</strong> (Kersik-Style)</span>
                <span class="text-slate-600">|</span>
                <span>Didukung oleh <strong class="text-[#87de57]">OpenSID & Diskominfo Bangkep</strong></span>
            </div>
        </div>
    </div>
</footer>
