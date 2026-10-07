@extends('diskominfo::layouts.master')

@section('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map-container {
        height: 620px;
        width: 100%;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .gis-layout {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .gis-layout {
            grid-template-columns: 1fr;
        }
    }

    .village-marker-card {
        padding: 0.9rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .village-marker-card:hover, .village-marker-card.active {
        border-color: var(--accent-cyan);
        background: rgba(0, 229, 255, 0.08);
        transform: translateX(4px);
    }

    /* Custom Leaflet Dark Popup */
    .leaflet-popup-content-wrapper {
        background: #111827 !important;
        color: #fff !important;
        border: 1px solid rgba(0, 229, 255, 0.4) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
    }

    .leaflet-popup-tip {
        background: #111827 !important;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem;">
            <i class="fa-solid fa-map-location-dot" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
            WebGIS Spasial Kabupaten Banggai Kepulauan
        </h2>
        <p style="color: var(--text-muted); font-size: 0.88rem;">
            Pemetaan geografis persebaran desa digital dan simpul data Smart Village (Fokus: Desa Bobu, Tinangkung Selatan).
        </p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <span class="badge-pill badge-cyan"><i class="fa-solid fa-satellite"></i> Sentinel Layer Active</span>
        <span class="badge-pill badge-emerald"><i class="fa-solid fa-check"></i> GPS Verified</span>
    </div>
</div>

<div class="gis-layout">
    <!-- Map Container -->
    <div class="glass-card" style="padding: 1rem;">
        <div id="map-container"></div>
    </div>

    <!-- Sidebar Village Points -->
    <div class="glass-card">
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-location-crosshairs" style="color: var(--accent-cyan);"></i> Titik Simpul Desa
        </h3>

        @foreach($tenants as $t)
        <div class="village-marker-card {{ $t->slug === 'bobu' ? 'active' : '' }}" onclick="focusVillage({{ $t->lat }}, {{ $t->lng }}, '{{ $t->nama_desa }}')">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                <strong style="color: #fff; font-size: 0.95rem;">{{ $t->nama_desa }}</strong>
                @if($t->slug === 'bobu')
                    <span class="badge-pill badge-emerald" style="font-size: 0.65rem;">PILOT</span>
                @else
                    <span class="badge-pill badge-blue" style="font-size: 0.65rem;">ONLINE</span>
                @endif
            </div>
            <div style="font-size: 0.78rem; color: var(--text-subtle);">
                Kecamatan {{ $t->kecamatan }}
            </div>
            <div style="font-size: 0.75rem; color: var(--accent-cyan); font-family: 'JetBrains Mono', monospace; margin-top: 0.35rem;">
                Lat: {{ $t->lat }}, Lng: {{ $t->lng }}
            </div>
        </div>
        @endforeach

        <div style="margin-top: 1.5rem; padding: 1rem; border-radius: 12px; background: rgba(0, 229, 255, 0.05); border: 1px solid rgba(0, 229, 255, 0.2);">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--accent-cyan); margin-bottom: 0.3rem;">
                <i class="fa-solid fa-circle-info"></i> Info Geografis
            </div>
            <p style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.5;">
                Kabupaten Banggai Kepulauan terdiri dari gugusan pulau dengan ibukota di Salakan. Desa Bobu terletak strategis di pesisir selatan Kecamatan Tinangkung Selatan.
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Koordinat Pusat Banggai Kepulauan
    const map = L.map('map-container').setView([-1.385200, 123.321400], 11);

    // Dark Tile Layer (CartoDB DarkMatter)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // Data Desa dari PHP
    const villages = [
        @foreach($tenants as $t)
        {
            nama: "{{ $t->nama_desa }}",
            slug: "{{ $t->slug }}",
            kecamatan: "{{ $t->kecamatan }}",
            lat: {{ $t->lat }},
            lng: {{ $t->lng }},
            penduduk: "{{ number_format($t->total_penduduk, 0, ',', '.') }}",
            subdomain: "{{ $t->subdomain }}",
            isPilot: {{ $t->slug === 'bobu' ? 'true' : 'false' }}
        },
        @endforeach
    ];

    const markers = {};

    villages.forEach(v => {
        // Icon penanda
        const marker = L.circleMarker([v.lat, v.lng], {
            radius: v.isPilot ? 12 : 9,
            fillColor: v.isPilot ? "#00e5ff" : "#3b82f6",
            color: "#ffffff",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.85
        }).addTo(map);

        const popupContent = `
            <div style="min-width: 180px; padding: 4px;">
                <div style="font-weight: 700; font-size: 1rem; color: #fff; margin-bottom: 2px;">
                    ${v.nama} ${v.isPilot ? '<span style="font-size: 10px; background: #00e5ff; color: #000; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">PILOT</span>' : ''}
                </div>
                <div style="font-size: 12px; color: #94a3b8; margin-bottom: 8px;">Kec. ${v.kecamatan}</div>
                <div style="font-size: 12px; color: #cbd5e1; margin-bottom: 4px;">
                    👥 Populasi: <strong>${v.penduduk} Jiwa</strong>
                </div>
                <div style="font-size: 11px; font-family: monospace; color: #00e5ff; margin-bottom: 10px;">
                    🌐 ${v.subdomain}
                </div>
                <a href="${'{{ base_url("index.php?desa=") }}' + v.slug}" target="_blank" style="display: block; text-align: center; background: #00e5ff; color: #04121e; padding: 6px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-decoration: none;">
                    Buka Portal Desa &rarr;
                </a>
            </div>
        `;

        marker.bindPopup(popupContent);
        markers[v.slug] = marker;

        if (v.isPilot) {
            marker.openPopup();
        }
    });

    function focusVillage(lat, lng, nama) {
        map.flyTo([lat, lng], 13, { duration: 1.5 });
    }
</script>
@endsection
