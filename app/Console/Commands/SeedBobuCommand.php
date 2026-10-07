<?php

namespace App\Console\Commands;

use App\Models\Artikel;
use App\Models\Config;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SeedBobuCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'opensid:seed-bobu';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Inisialisasi dan isi data demo lengkap Desa Bobu (Kec. Tinangkung Selatan, Banggai Kepulauan)';

    /**
     * Jalankan perintah pengisian data.
     */
    public function handle(): int
    {
        $this->info('🚀 Memulai inisialisasi data Desa Bobu (Pilot Project Smart Village)...');

        // 1. Identitas Desa (Tabel: config)
        $this->seedIdentitasDesa();

        // 2. Kategori Berita (Tabel: kategori)
        $this->seedKategori();

        // 3. User Admin OpenSID (Tabel: user)
        $this->seedUserAdmin();

        // 4. Berita & Artikel Sambutan (Tabel: artikel)
        $this->seedArtikel();

        // 5. Dusun / Wilayah Administratif (Tabel: tweb_wilayah)
        $this->seedWilayah();

        // 6. Reset & Refresh Cache
        $this->flushCache();

        $this->info('🎉 Data demo Desa Bobu berhasil terpasang dan aktif di database!');
        $this->info('👉 Silakan akses: http://148.230.102.95:8090/index.php?desa=bobu');

        return Command::SUCCESS;
    }

    /**
     * Pasang data Identitas Desa Bobu pada tabel config.
     */
    protected function seedIdentitasDesa(): void
    {
        $data = [
            'nama_desa'         => 'Bobu',
            'kode_desa'         => '7207032001',
            'kode_desa_bps'     => '7207032001',
            'nama_kecamatan'    => 'Tinangkung Selatan',
            'kode_kecamatan'    => '720703',
            'nama_kabupaten'    => 'Banggai Kepulauan',
            'kode_kabupaten'    => '7207',
            'nama_propinsi'     => 'Sulawesi Tengah',
            'kode_propinsi'     => '72',
            'kode_pos'          => '94785',
            'email_desa'        => 'pemdes@bobu.desa.id',
            'telepon'           => '082199887766',
            'website'           => 'https://bobu.banggaikep.go.id',
            'alamat_kantor'     => 'Jl. Trans Banggai Kepulauan, Desa Bobu, Kec. Tinangkung Selatan',
            'nama_kepala_camat' => 'Ilyas M. Tadja',
            'lat'               => -1.385200,
            'lng'               => 123.321400,
            'zoom'              => 14,
        ];

        if (Schema::hasTable('config')) {
            $config = Config::first();
            if ($config) {
                $config->update($data);
                $this->info('✅ [1/5] Identitas Desa Bobu berhasil diperbarui di tabel config.');
            } else {
                Config::create(array_merge($data, [
                    'app_key' => function_exists('get_app_key') ? get_app_key() : 'base64:rN3vXWFRHDKFP2sMySe9f4gna7WulisoXTqn7Yo4Ye8=',
                ]));
                $this->info('✅ [1/5] Identitas Desa Bobu berhasil dibuat di tabel config.');
            }
        }
    }

    /**
     * Pastikan kategori artikel tersedia.
     */
    protected function seedKategori(): void
    {
        if (Schema::hasTable('kategori')) {
            DB::table('kategori')->updateOrInsert(
                ['id' => 1],
                [
                    'kategori' => 'Berita Desa',
                    'tipe'     => 1,
                    'urut'     => 1,
                    'enabled'  => 1,
                ]
            );

            DB::table('kategori')->updateOrInsert(
                ['id' => 2],
                [
                    'kategori' => 'Pengumuman',
                    'tipe'     => 2,
                    'urut'     => 2,
                    'enabled'  => 1,
                ]
            );
            $this->info('✅ [2/5] Kategori artikel (Berita Desa & Pengumuman) siap.');
        }
    }

    /**
     * Pastikan user Administrator tersedia untuk login /siteman.
     */
    protected function seedUserAdmin(): void
    {
        if (Schema::hasTable('user')) {
            $configId = DB::table('config')->value('id') ?? 1;
            $hash     = Hash::make('sid304');

            DB::table('user')->updateOrInsert(
                ['username' => 'admin'],
                [
                    'config_id' => $configId,
                    'password'  => $hash,
                    'nama'      => 'Administrator Desa Bobu',
                    'id_grup'   => 1,
                    'email'     => 'admin@bobu.desa.id',
                    'active'    => 1,
                ]
            );

            // Samakan seluruh user agar config_id konsisten
            DB::table('user')->whereNull('config_id')->orWhere('config_id', 0)->update(['config_id' => $configId]);

            $this->info("✅ [3/5] Akun Admin siap & disinkronkan (user: admin / pass: sid304, config_id: {$configId}).");
        }
    }

    /**
     * Masukkan artikel dan berita pembuka website Desa Bobu.
     */
    protected function seedArtikel(): void
    {
        if (Schema::hasTable('artikel')) {
            $artikelList = [
                [
                    'judul'          => 'Selamat Datang di Portal Resmi Desa Bobu, Kec. Tinangkung Selatan',
                    'slug'           => 'selamat-datang-di-portal-resmi-desa-bobu',
                    'isi'            => '<p>Selamat datang di portal informasi resmi dan layanan digital publik Pemerintah Desa Bobu, Kecamatan Tinangkung Selatan, Kabupaten Banggai Kepulauan.</p><p>Sebagai wujud transparansi tata kelola pemerintahan dan keterbukaan informasi publik, portal ini terintegrasi langsung dengan platform Command Center SaaS Diskominfo Kabupaten Banggai Kepulauan. Warga Desa Bobu kini dapat mengakses informasi pembangunan desa, anggaran APBDes, serta mengajukan layanan administrasi persuratan secara mandiri dan transparan.</p>',
                    'enabled'        => 1,
                    'headline'       => 1,
                    'slider'         => 1,
                    'id_kategori'    => 1,
                    'id_user'        => 1,
                    'tgl_upload'     => date('Y-m-d H:i:s'),
                    'boleh_komentar' => 1,
                ],
                [
                    'judul'          => 'Transformasi Digital: Desa Bobu Resmi Menjadi Pilot Project Smart Village Banggai Kepulauan',
                    'slug'           => 'transformasi-digital-desa-bobu-pilot-project-smart-village',
                    'isi'            => '<p>Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Banggai Kepulauan secara resmi menetapkan Desa Bobu sebagai Desa Percontohan (Pilot Project) implementasi Smart Village berbasis OpenSID SaaS Cloud Terpadu.</p><p>Dengan integrasi ini, seluruh data kependudukan dan statistik desa tersinkronisasi secara otomatis ke dashboard pimpinan daerah di Salakan guna mendukung perumusan kebijakan yang akurat dan berbasis data real-time.</p>',
                    'enabled'        => 1,
                    'headline'       => 0,
                    'slider'         => 1,
                    'id_kategori'    => 1,
                    'id_user'        => 1,
                    'tgl_upload'     => date('Y-m-d H:i:s', strtotime('-1 day')),
                    'boleh_komentar' => 1,
                ],
                [
                    'judul'          => 'Layanan Administrasi Kependudukan Cepat & Mandiri Kini Hadir di Desa Bobu',
                    'slug'           => 'layanan-administrasi-kependudukan-cepat-dan-mandiri-desa-bobu',
                    'isi'            => '<p>Pemerintah Desa Bobu terus berkomitmen meningkatkan kualitas pelayanan publik. Melalui sistem pelayanan mandiri, warga dapat mengajukan permohonan Surat Keterangan Usaha (UMKM), Domisili, Pengantar SKCK, maupun Keterangan DTKS dengan proses yang cepat dan terarsip digital.</p>',
                    'enabled'        => 1,
                    'headline'       => 0,
                    'slider'         => 1,
                    'id_kategori'    => 1,
                    'id_user'        => 1,
                    'tgl_upload'     => date('Y-m-d H:i:s', strtotime('-2 days')),
                    'boleh_komentar' => 1,
                ],
            ];

            foreach ($artikelList as $item) {
                DB::table('artikel')->updateOrInsert(
                    ['slug' => $item['slug']],
                    $item
                );
            }

            $this->info('✅ [4/5] 3 Artikel & Banner Berita Desa Bobu berhasil dipasang.');
        }
    }

    /**
     * Masukkan dusun dan wilayah administratif.
     */
    protected function seedWilayah(): void
    {
        if (Schema::hasTable('tweb_wilayah')) {
            $wilayahList = ['Dusun I Bobu Pantai', 'Dusun II Bobu Tengah', 'Dusun III Bobu Timur'];

            foreach ($wilayahList as $idx => $dusun) {
                DB::table('tweb_wilayah')->updateOrInsert(
                    ['dusun' => $dusun],
                    [
                        'rw'   => '-',
                        'rt'   => '-',
                        'urut' => $idx + 1,
                    ]
                );
            }

            $this->info('✅ [5/5] Wilayah administratif 3 Dusun Desa Bobu siap.');
        }
    }

    /**
     * Bersihkan cache sistem.
     */
    protected function flushCache(): void
    {
        try {
            (new Config())->flushQueryCache();
        } catch (\Throwable $e) {
            // Abaikan jika cache query tidak aktif
        }

        if (function_exists('resetCacheDesa')) {
            resetCacheDesa();
        }

        $this->callSilent('cache:clear');
        $this->callSilent('view:clear');
    }
}
