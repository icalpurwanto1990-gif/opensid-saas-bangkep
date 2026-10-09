<?php

namespace App\Console\Commands;

use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ActivateThemeCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'opensid:activate-theme {slug=bobu-gov}';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Pindai dan aktifkan tema OpenSID (misal: bobu-gov, natra, esensi)';

    /**
     * Eksekusi aktivasi tema.
     */
    public function handle(): int
    {
        $targetSlug = (string) $this->argument('slug');

        $this->info("🔍 [1/3] Memindai seluruh tema terdaftar...");

        if (function_exists('theme_scan')) {
            theme_scan();
        } else {
            // Manual fallback scan jika helper belum termuat
            $themeSistem = glob('storage/app/themes/*', GLOB_ONLYDIR);
            $themeDesa   = glob('desa/themes/*', GLOB_ONLYDIR);
            $configId    = DB::table('config')->value('id') ?? 1;

            $themeList = collect($themeSistem)->merge($themeDesa)
                ->filter(static fn ($tema): bool => is_file($tema . '/composer.json') && is_file($tema . '/resources/views/template.blade.php'))
                ->map(static function (string $tema) use ($configId) {
                    $sistem     = preg_match('/storage/', $tema) ? 1 : 0;
                    $composer   = json_decode(file_get_contents($tema . '/composer.json'), true);
                    $versi      = $composer['version'] ?? '1.0.0';
                    $nama       = str_replace('-', ' ', explode('/', $composer['name'])[1]);
                    $slug       = Str::slug(($sistem ? '' : 'desa ') . $nama);
                    $keterangan = $composer['description'] ?? 'Tema OpenSID';

                    return [
                        'config_id'  => $configId,
                        'nama'       => ucwords($nama),
                        'slug'       => $slug,
                        'versi'      => $versi,
                        'sistem'     => $sistem,
                        'path'       => $tema,
                        'keterangan' => $keterangan,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                })
                ->toArray();

            if (! empty($themeList) && Schema::hasTable('theme')) {
                DB::table('theme')->upsert($themeList, 'slug');
            }
        }

        $this->info("🎨 [2/3] Mengaktifkan tema: '{$targetSlug}'...");

        if (! Schema::hasTable('theme')) {
            $this->error("Tabel 'theme' belum ditemukan di database.");
            return Command::FAILURE;
        }

        // Cari tema dengan kecocokan slug atau nama
        $theme = DB::table('theme')
            ->where('slug', $targetSlug)
            ->orWhere('slug', 'desa-' . $targetSlug)
            ->orWhere('path', 'like', "%{$targetSlug}%")
            ->first();

        if (! $theme) {
            $this->error("Tema dengan slug/path '{$targetSlug}' tidak ditemukan.");
            $this->table(
                ['ID', 'Nama', 'Slug', 'Path', 'Status'],
                DB::table('theme')->get(['id', 'nama', 'slug', 'path', 'status'])->toArray()
            );
            return Command::FAILURE;
        }

        // Nonaktifkan semua tema, lalu aktifkan tema target
        DB::table('theme')->update(['status' => 0]);
        DB::table('theme')->where('id', $theme->id)->update(['status' => 1]);

        $this->info("🧹 [3/3] Membersihkan cache tema...");
        cache()->forget('theme_active');
        if (function_exists('cache')) {
            try {
                cache()->flush();
            } catch (\Throwable $e) {
                // Abaikan jika cache driver redis/file tidak support flush
            }
        }

        $this->newLine();
        $this->info("✅ Tema '{$theme->nama}' (slug: {$theme->slug}) BERHASIL DIAKTIFKAN!");
        $this->table(
            ['ID', 'Nama Tema', 'Slug', 'Status', 'Path'],
            DB::table('theme')->get(['id', 'nama', 'slug', 'status', 'path'])->toArray()
        );

        return Command::SUCCESS;
    }
}
