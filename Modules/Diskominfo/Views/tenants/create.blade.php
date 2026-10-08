@extends('diskominfo::layouts.master')

@section('content')
<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <a href="{{ site_url('diskominfo/desa') }}" style="color: var(--accent-cyan); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Desa
            </a>
            <h2 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0;">
                <i class="fa-solid fa-server" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
                Registrasi Simpul Desa & Vendor Eksternal
            </h2>
        </div>
        <span class="badge-pill badge-cyan" style="font-size: 0.85rem; padding: 0.4rem 1rem;">
            Kabupaten Banggai Kepulauan
        </span>
    </div>
    <p style="color: var(--text-muted); font-size: 0.92rem;">
        Integrasikan website desa dari berbagai penyedia/vendor (cPanel, Cloud VPS, atau Custom CMS) ke dalam 
        Pusat Komando dan Pengawasan SLA Diskominfo Banggai Kepulauan.
    </p>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
    <!-- Form Registrasi -->
    <div class="glass-card">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-file-signature" style="color: var(--accent-emerald);"></i> Formulir Pendaftaran Simpul Desa
        </h3>

        <form action="{{ site_url('diskominfo/desa/store') }}" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Nama Desa <span style="color: var(--accent-rose);">*</span>
                    </label>
                    <input type="text" name="nama_desa" required placeholder="Contoh: Desa Mansamat"
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Slug Identitas (Huruf Kecil) <span style="color: var(--accent-rose);">*</span>
                    </label>
                    <input type="text" name="slug" required placeholder="Contoh: mansamat" pattern="[a-z0-9_]+"
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #38bdf8; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Kecamatan <span style="color: var(--accent-rose);">*</span>
                    </label>
                    <select name="kecamatan" required
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                        <option value="Tinangkung">Tinangkung</option>
                        <option value="Tinangkung Selatan" selected>Tinangkung Selatan</option>
                        <option value="Tinangkung Utara">Tinangkung Utara</option>
                        <option value="Totikum">Totikum</option>
                        <option value="Totikum Selatan">Totikum Selatan</option>
                        <option value="Liang">Liang</option>
                        <option value="Peling Tengah">Peling Tengah</option>
                        <option value="Bulagi">Bulagi</option>
                        <option value="Bulagi Selatan">Bulagi Selatan</option>
                        <option value="Bulagi Utara">Bulagi Utara</option>
                        <option value="Buko">Buko</option>
                        <option value="Buko Selatan">Buko Selatan</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Kode Kemendagri Wilayah
                    </label>
                    <input type="text" name="kode_desa" placeholder="Contoh: 72.07.03.2001"
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Tipe Arsitektur / Hosting <span style="color: var(--accent-rose);">*</span>
                    </label>
                    <select name="tipe_server" required
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                        <option value="saas_internal">Diskominfo Multi-Tenant SaaS (Lokal VPS)</option>
                        <option value="external_hosting" selected>Shared Cloud Hosting / cPanel (Vendor Eksternal)</option>
                        <option value="external_vps">Dedicated VPS Mandiri (Desa / Vendor)</option>
                        <option value="custom_cms">Custom CMS / Aplikasi Swadaya</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Target Kepatuhan SLA (%)
                    </label>
                    <input type="number" step="0.1" name="sla_target" value="99.0" min="90" max="100"
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #10b981; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                    URL Portal Publik Desa (Untuk Ping SLA & Health Check) <span style="color: var(--accent-rose);">*</span>
                </label>
                <input type="url" name="url_portal" required placeholder="https://mansamat.desa.id atau http://ip-server:port"
                    style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                <small style="color: var(--text-subtle); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                    Sistem akan melakukan health-ping berkala ke URL ini untuk memonitor uptime dan response latency.
                </small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.75rem;">
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Nama Perusahaan Vendor / Pengelola
                    </label>
                    <input type="text" name="vendor_name" placeholder="Contoh: PT Media Nusa Digital"
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.82rem; font-weight: 600; color: #e2e8f0; margin-bottom: 0.4rem;">
                        Kontak PIC Vendor (WhatsApp / Email)
                    </label>
                    <input type="text" name="vendor_contact" placeholder="Contoh: 0812-3456-7890 (Bpk. Ahmad)"
                        style="width: 100%; padding: 0.65rem 0.9rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; font-size: 0.9rem; outline: none;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ site_url('diskominfo/desa') }}" class="btn-action btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn-action btn-cyan" style="cursor: pointer; border: none; font-weight: 700;">
                    <i class="fa-solid fa-plus-circle"></i> Daftarkan Simpul Desa
                </button>
            </div>
        </form>
    </div>

    <!-- Panel Informasi & Panduan Integrasi API -->
    <div>
        <div class="glass-card" style="margin-bottom: 1.5rem; border-color: rgba(0, 229, 255, 0.3);">
            <h4 style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-circle-nodes" style="color: var(--accent-cyan);"></i> Integrasi Multi-Vendor
            </h4>
            <p style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.75rem;">
                Diskominfo Banggai Kepulauan mendukung integrasi dengan vendor eksternal manapun tanpa mewajibkan pemindahan server fisik.
            </p>
            <ul style="font-size: 0.8rem; color: var(--text-muted); padding-left: 1.2rem; line-height: 1.6; margin: 0;">
                <li>Pemantauan uptime otomatis via URL Health Check.</li>
                <li>Pengiriman data kependudukan via REST API Ingest.</li>
                <li>Pelaporan SLA resmi dan evaluasi performa vendor.</li>
            </ul>
        </div>

        <div class="glass-card" style="border-color: rgba(16, 185, 129, 0.3);">
            <h4 style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-code" style="color: var(--accent-emerald);"></i> Cuplikan REST API Vendor
            </h4>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                Vendor eksternal dapat mengirimkan data agregat statistik desa menggunakan format JSON:
            </p>
            <pre style="background: rgba(0, 0, 0, 0.5); padding: 0.75rem; border-radius: 6px; font-size: 0.72rem; color: #38bdf8; overflow-x: auto; font-family: 'JetBrains Mono', monospace; border: 1px solid rgba(255, 255, 255, 0.08); margin: 0;">
curl -X POST \
  http://148.230.102.95:8090/index.php/diskominfo/api/ingest \
  -H "X-Diskominfo-Token: KAB_BANGKEP_SECURE_TOKEN_2026" \
  -H "Content-Type: application/json" \
  -d '{
    "slug": "mansamat",
    "total_penduduk": 1820,
    "total_kk": 512,
    "surat_bulan_ini": 45,
    "anggaran_apbdes": 1150000000
  }'
            </pre>
        </div>
    </div>
</div>
@endsection
