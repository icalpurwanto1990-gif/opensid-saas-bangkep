@php
    $items = [];
    if (!empty($stat_widget) && is_array($stat_widget)) {
        foreach ($stat_widget as $st) {
            if (!empty($st['nama']) && isset($st['jumlah']) && $st['jumlah'] > 0) {
                $items[] = [
                    'label' => $st['nama'],
                    'value' => $st['jumlah'],
                    'icon'  => 'fa-users'
                ];
            }
        }
    }
@endphp

@if (!empty($items))
    <div class="container mx-auto px-4 lg:px-8 -mt-6 relative z-20">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach (array_slice($items, 0, 4) as $index => $stat)
                <div class="kersik-stat-card">
                    <div class="kersik-stat-icon">
                        <i class="fas {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="kersik-stat-number gov-counter" data-target="{{ $stat['value'] }}">{{ number_format($stat['value'], 0, ',', '.') }}</div>
                        <div class="kersik-stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
