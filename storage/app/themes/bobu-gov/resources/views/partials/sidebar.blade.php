<aside class="space-y-6 sidebar">
    <!-- Quick Search Widget -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
        <form action="{{ site_url('/') }}" method="get" role="form" class="relative">
            <input type="text" name="cari" value="{{ request('cari') }}"
                   class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white transition"
                   placeholder="Cari berita atau informasi...">
            <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
        </form>
    </div>

    <!-- Tampilkan Widget Aktif OpenSID -->
    @if (!empty($widgetAktif))
        @foreach ($widgetAktif as $widget)
            @php
                $judul_widget = [
                    'judul_widget' => str_replace('Desa', ucwords(setting('sebutan_desa')), strip_tags($widget['judul'])),
                ];
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden transition-all hover:shadow-md">
                @includeIf("theme::widgets.{$widget['isi']}", $judul_widget)
            </div>
        @endforeach
    @endif
</aside>
