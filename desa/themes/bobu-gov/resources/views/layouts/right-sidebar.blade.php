@extends('theme::template')

@section('layout')
    @yield('top_showcase')

    <div class="container mx-auto px-4 lg:px-8 flex flex-col lg:flex-row my-8 gap-8 justify-between">
        {{-- Main Content Column --}}
        <main class="lg:w-2/3 w-full">
            @yield('content')
        </main>

        {{-- Sidebar Widgets Column --}}
        <div class="lg:w-1/3 w-full">
            @include('theme::partials.sidebar')
        </div>
    </div>

    @yield('bottom_showcase')
@endsection
