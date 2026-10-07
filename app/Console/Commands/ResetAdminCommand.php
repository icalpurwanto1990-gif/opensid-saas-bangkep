<?php

namespace App\Console\Commands;

use App\Models\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ResetAdminCommand extends Command
{
    /**
     * Signature command artisan.
     *
     * @var string
     */
    protected $signature = 'opensid:reset-admin {username=admin} {password=sid304}';

    /**
     * Deskripsi command artisan.
     *
     * @var string
     */
    protected $description = 'Reset username dan password administrator OpenSID secara instan';

    /**
     * Eksekusi reset akun administrator.
     */
    public function handle(): int
    {
        $username = (string) $this->argument('username');
        $password = (string) $this->argument('password');

        if (! Schema::hasTable('user')) {
            $this->error('Tabel user belum tersedia di database.');

            return Command::FAILURE;
        }

        $configId = DB::table('config')->value('id') ?? 1;
        $hash     = Hash::make($password);

        DB::table('user')->updateOrInsert(
            ['username' => $username],
            [
                'config_id' => $configId,
                'password'  => $hash,
                'nama'      => 'Administrator Desa Bobu',
                'id_grup'   => 1,
                'email'     => 'admin@bobu.desa.id',
                'active'    => 1,
            ]
        );

        // Pastikan seluruh user memiliki config_id yang valid
        DB::table('user')->whereNull('config_id')->orWhere('config_id', 0)->update(['config_id' => $configId]);

        // Bersihkan cache login dan rate limiting
        try {
            (new Config())->flushQueryCache();
        } catch (\Throwable $e) {}

        if (app()->bound('cache')) {
            app('cache')->flush();
        }

        $this->callSilent('cache:clear');

        $this->info('================================================================');
        $this->info('🔑 AKUN ADMINISTRATOR OPENSID BERHASIL DIRESET!');
        $this->info("   Username  : {$username}");
        $this->info("   Password  : {$password}");
        $this->info("   Config ID : {$configId}");
        $this->info("   Status    : Aktif (Active = 1)");
        $this->info('================================================================');
        $this->info('👉 Silakan login di: http://148.230.102.95:8090/index.php/siteman');

        return Command::SUCCESS;
    }
}
