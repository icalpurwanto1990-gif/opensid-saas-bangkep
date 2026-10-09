@php
    $themeVersion = 'v1.2.0';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('theme::commons.meta')
    @include('theme::commons.source_css')
    @include('theme::commons.source_js')
    <title>@yield('title')</title>
    @stack('styles')
</head>

<body class="bg-[#ffffff] text-[#000000] antialiased flex flex-col min-h-screen selection:bg-[#87de57] selection:text-black font-['Outfit']">
    @include('theme::commons.loading_screen')
    @include('theme::commons.header')

    <div class="flex-grow">
        @yield('layout')
    </div>

    @include('theme::commons.footer')

    <script src="{{ theme_asset('js/script.min.js') }}&{{ $themeVersion }}"></script>
    <script src="{{ theme_asset('js/bobu-gov.js', ['themeVersion' => $themeVersion]) }}"></script>
    <script type="text/javascript">
        function formatRupiah(angka, prefix = 'Rp ') {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '') + ',00';
        }
    </script>
    @stack('scripts')
</body>

</html>
