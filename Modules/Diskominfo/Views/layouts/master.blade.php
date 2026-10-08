<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Diskominfo Command Center - Kab. Banggai Kepulauan' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg-base: #0a0f1d;
            --bg-surface: #111827;
            --bg-card: rgba(17, 24, 39, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(0, 229, 255, 0.3);
            --accent-cyan: #00e5ff;
            --accent-blue: #3b82f6;
            --accent-emerald: #10b981;
            --accent-amber: #f59e0b;
            --accent-rose: #f43f5e;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --text-subtle: #64748b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(0, 229, 255, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
        }

        /* Top Navigation Bar */
        .topbar {
            height: 72px;
            background: rgba(10, 15, 29, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0284c7, #00e5ff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            box-shadow: 0 0 20px rgba(0, 229, 255, 0.35);
        }

        .brand-titles h1 {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-titles p {
            font-size: 0.75rem;
            color: var(--accent-cyan);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-link {
            padding: 0.6rem 1.1rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--border-color);
        }

        .nav-link.active {
            background: rgba(0, 229, 255, 0.1);
            color: var(--accent-cyan);
            border-color: rgba(0, 229, 255, 0.3);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .live-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 0.4rem 0.85rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--accent-emerald);
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--accent-emerald);
            box-shadow: 0 0 10px var(--accent-emerald);
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.8; }
        }

        /* Container & Layout */
        .main-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            flex: 1;
        }

        /* Footer */
        .footer {
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            font-size: 0.8rem;
            color: var(--text-subtle);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 15, 29, 0.6);
        }

        /* Utility Components */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .glass-card:hover {
            border-color: var(--border-hover);
        }

        .badge-pill {
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .badge-cyan { background: rgba(0, 229, 255, 0.12); color: var(--accent-cyan); border: 1px solid rgba(0, 229, 255, 0.3); }
        .badge-emerald { background: rgba(16, 185, 129, 0.12); color: var(--accent-emerald); border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-amber { background: rgba(245, 158, 11, 0.12); color: var(--accent-amber); border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge-blue { background: rgba(59, 130, 246, 0.12); color: var(--accent-blue); border: 1px solid rgba(59, 130, 246, 0.3); }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-cyan {
            background: linear-gradient(135deg, #0284c7, #00e5ff);
            color: #04121e;
            box-shadow: 0 4px 15px rgba(0, 229, 255, 0.25);
        }

        .btn-cyan:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 229, 255, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Header Topbar -->
    <header class="topbar">
        <div class="brand-section">
            <div class="brand-badge">
                <i class="fa-solid fa-tower-broadcast"></i>
            </div>
            <div class="brand-titles">
                <h1>DISKOMINFO COMMAND CENTER</h1>
                <p>Kabupaten Banggai Kepulauan • Platform Terpadu Smart Village</p>
            </div>
        </div>

        <nav>
            <ul class="nav-links">
                <li>
                    <a href="{{ site_url('diskominfo') }}" class="nav-link {{ request()->is('diskominfo') || request()->is('diskominfo/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i> Eksekutif
                    </a>
                </li>
                <li>
                    <a href="{{ site_url('diskominfo/sla') }}" class="nav-link {{ request()->is('diskominfo/sla*') ? 'active' : '' }}">
                        <i class="fa-solid fa-heart-pulse" style="color: var(--accent-emerald);"></i> Pusat SLA & Vendor
                    </a>
                </li>
                <li>
                    <a href="{{ site_url('diskominfo/desa') }}" class="nav-link {{ request()->is('diskominfo/desa*') ? 'active' : '' }}">
                        <i class="fa-solid fa-network-wired"></i> Desa (Multi-Vendor)
                    </a>
                </li>
                <li>
                    <a href="{{ site_url('diskominfo/gis') }}" class="nav-link {{ request()->is('diskominfo/gis*') ? 'active' : '' }}">
                        <i class="fa-solid fa-map-location-dot"></i> WebGIS
                    </a>
                </li>
                <li>
                    <a href="{{ site_url('diskominfo/laporan') }}" class="nav-link {{ request()->is('diskominfo/laporan*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-shield" style="color: var(--accent-amber);"></i> Laporan SLA
                    </a>
                </li>
            </ul>
        </nav>

        <div class="header-actions">
            <div class="live-indicator">
                <span class="pulse-dot"></span>
                LIVE NETWORK
            </div>
            <a href="{{ base_url('index.php?desa=bobu') }}" target="_blank" class="btn-action btn-cyan">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Portal Desa Bobu
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div>
            © 2026 Dinas Komunikasi dan Informatika Kabupaten Banggai Kepulauan. Sistem Terpadu SaaS OpenSID.
        </div>
        <div>
            Pilot Project: <strong>Desa Bobu</strong> (Kec. Tinangkung Selatan) • Versi 2607.0.1 Enterprise
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
