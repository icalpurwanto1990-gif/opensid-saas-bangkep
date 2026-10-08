<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login Web Admin Diskominfo - Kab. Banggai Kepulauan' }}</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-dark: #070d18;
            --bg-card: rgba(15, 23, 42, 0.75);
            --accent-cyan: #00e5ff;
            --accent-emerald: #10b981;
            --accent-rose: #f43f5e;
            --border-color: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow Effect */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 229, 255, 0.15), transparent 70%);
            top: -100px;
            left: -100px;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }

        .ambient-glow-bottom {
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12), transparent 70%);
            bottom: -100px;
            right: -100px;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
        }

        .login-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-icon {
            width: 68px;
            height: 68px;
            background: linear-gradient(135deg, rgba(0, 229, 255, 0.2), rgba(16, 185, 129, 0.2));
            border: 1px solid rgba(0, 229, 255, 0.4);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--accent-cyan);
            margin-bottom: 1rem;
            box-shadow: 0 0 25px rgba(0, 229, 255, 0.2);
        }

        .brand-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .brand-sub {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }

        .badge-scope {
            display: inline-block;
            background: rgba(0, 229, 255, 0.1);
            border: 1px solid rgba(0, 229, 255, 0.3);
            color: var(--accent-cyan);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            margin-top: 0.6rem;
            letter-spacing: 0.05em;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.4rem;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            color: #fff;
            font-size: 0.92rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 15px rgba(0, 229, 255, 0.2);
            background: rgba(15, 23, 42, 0.95);
        }

        .btn-submit {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #0284c7, #00e5ff);
            color: #04121e;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 229, 255, 0.3);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 229, 255, 0.45);
        }

        .alert-box {
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.4);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            color: #fda4af;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.4);
            color: #6ee7b7;
        }

        .footer-note {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.8rem;
            color: #64748b;
        }

        .footer-note a {
            color: var(--accent-cyan);
            text-decoration: none;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>
    <div class="ambient-glow-bottom"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-header">
                <div class="brand-icon">
                    <i class="fa-solid fa-tower-broadcast"></i>
                </div>
                <h1 class="brand-title">Pusat Komando Diskominfo</h1>
                <p class="brand-sub">Pemerintah Kabupaten Banggai Kepulauan</p>
                <div class="badge-scope">
                    <i class="fa-solid fa-lock"></i> Otentikasi Terisolasi Tingkat Kabupaten
                </div>
            </div>

            @if(!empty($error) || !empty($_SESSION['login_error']))
            <div class="alert-box">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $error ?? $_SESSION['login_error'] }}</span>
            </div>
            @php unset($_SESSION['login_error']); @endphp
            @endif

            @if(!empty($_SESSION['flash_info']) || !empty($_GET['logged_out']))
            <div class="alert-box alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ $_SESSION['flash_info'] ?? 'Sesi Anda telah berhasil diakhiri.' }}</span>
            </div>
            @php unset($_SESSION['flash_info']); @endphp
            @endif

            <form action="{{ site_url('diskominfo/login') }}" method="POST">
                <div class="form-group">
                    <label class="form-label" for="username">Username Admin Diskominfo</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user-shield input-icon"></i>
                        <input type="text" id="username" name="username" class="form-control" 
                               placeholder="admin_diskominfo" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi (Password)</label>
                    <div class="input-group">
                        <i class="fa-solid fa-key input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="••••••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk ke Pusat Komando
                </button>
            </form>

            <div class="footer-note">
                <p style="margin-bottom: 0.5rem;">
                    Bukan administrator Diskominfo? 
                    <a href="{{ base_url() }}"><i class="fa-solid fa-house"></i> Kembali ke Portal Desa</a>
                </p>
                <p style="font-size: 0.75rem; color: #475569;">
                    Basis Data Terisolasi: <code style="color: var(--accent-cyan);">opensid_diskominfo</code>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
