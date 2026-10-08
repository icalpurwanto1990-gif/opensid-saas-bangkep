<?php

namespace Modules\Diskominfo\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Diskominfo\Models\DiskominfoUser;
use PDO;
use Throwable;

class AuthController extends Controller
{
    /**
     * Pastikan namespace view diskominfo terdaftar.
     */
    protected function ensureViewNamespace(): void
    {
        $viewPath = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'Views';
        if (is_dir($viewPath)) {
            view()->addNamespace('diskominfo', $viewPath);
        }
    }

    /**
     * Tampilkan form login khusus Web Admin Diskominfo.
     */
    public function showLoginForm()
    {
        $this->ensureViewNamespace();

        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        // Jika sudah login, redirect langsung ke dashboard Diskominfo
        if (! empty($_SESSION['diskominfo_user'])) {
            return redirect(site_url('diskominfo'));
        }

        return view('diskominfo::auth.login', [
            'title' => 'Login Web Admin Diskominfo - Kab. Banggai Kepulauan',
            'error' => $_SESSION['login_error'] ?? null,
        ]);
    }

    /**
     * Proses autentikasi khusus admin Diskominfo.
     */
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        unset($_SESSION['login_error']);

        $username = trim((string) $this->input->post('username'));
        $password = trim((string) $this->input->post('password'));

        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Silakan masukkan username dan password.';
            return redirect(site_url('diskominfo/login'));
        }

        // 1. Cek autentikasi dari basis data opensid_diskominfo
        $authenticated = false;
        $userProfile   = null;

        try {
            $host   = getenv('DB_HOST') ?: 'db';
            $port   = (int) (getenv('DB_PORT') ?: 3306);
            $dbUser = getenv('DB_USERNAME') ?: 'opensid_user';
            $dbPass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'opensid_password';

            $pdo = new PDO("mysql:host={$host};port={$port};dbname=opensid_diskominfo;charset=utf8mb4", $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $stmt = $pdo->prepare("SELECT * FROM diskominfo_users WHERE username = ? AND status = 'aktif' LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $authenticated = true;
                $userProfile = [
                    'id'           => $user['id'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'email'        => $user['email'] ?? '',
                    'role'         => $user['role'] ?? 'superadmin',
                    'jabatan'      => $user['jabatan'] ?? 'Pengelola SPBE',
                ];

                // Update waktu login terakhir
                $pdo->prepare("UPDATE diskominfo_users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
            }
        } catch (Throwable $e) {
            // Jika basis data opensid_diskominfo belum di-setup, izinkan fallback superadmin default
            if ($username === 'admin_diskominfo' && $password === 'Bangkep@2026!') {
                $authenticated = true;
                $userProfile = [
                    'id'           => 1,
                    'username'     => 'admin_diskominfo',
                    'nama_lengkap' => 'Administrator Diskominfo Bangkep (Fallback)',
                    'email'        => 'admin.diskominfo@banggaikep.go.id',
                    'role'         => 'superadmin',
                    'jabatan'      => 'Pengelola SPBE Diskominfo',
                ];
            }
        }

        if (! $authenticated) {
            $_SESSION['login_error'] = 'Kredensial salah! Pastikan username dan password admin Diskominfo benar.';
            return redirect(site_url('diskominfo/login'));
        }

        // Set Sesi Khusus Diskominfo (Terisolasi dari sesi admin desa / siteman)
        $_SESSION['diskominfo_user'] = $userProfile;
        $_SESSION['flash_success']   = "Selamat datang kembali, {$userProfile['nama_lengkap']}!";

        return redirect(site_url('diskominfo'));
    }

    /**
     * Logout dari Web Admin Diskominfo.
     */
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        unset($_SESSION['diskominfo_user']);
        $_SESSION['flash_info'] = 'Anda telah berhasil keluar dari Pusat Komando Diskominfo.';

        return redirect(site_url('diskominfo/login'));
    }
}
