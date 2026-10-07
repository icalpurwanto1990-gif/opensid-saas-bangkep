<?php

namespace Modules\Diskominfo\Models;

use Illuminate\Database\Eloquent\Model;

class VillageMetric extends Model
{
    protected $table = 'village_metrics';

    protected $guarded = [];

    /**
     * Dapatkan ringkasan metrik se-Kabupaten Banggai Kepulauan.
     */
    public static function getKabupatenSummary(): array
    {
        return [
            'total_kecamatan' => 12,
            'total_desa'      => 141,
            'desa_terhubung'  => 4,
            'desa_pilot'      => 'Desa Bobu (Kec. Tinangkung Selatan)',
            'total_penduduk'  => 6798, // Sampel terintegrasi tahap 1
            'total_kk'        => 1858,
            'total_surat_terbit' => 1240,
            'total_bansos_tersalur' => 930,
            'rata_rata_apbdes' => 'Rp 1.150.000.000',
            'persentase_tte'  => '94.2%',
            'status_jaringan' => 'Stabil (99.8%)',
        ];
    }
}
