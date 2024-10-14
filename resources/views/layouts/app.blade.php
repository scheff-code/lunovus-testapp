<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
{{--        <title>{{ config('app.name', 'Laravel') }}</title>--}}

        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        @stack('styles')


        <!-- Scripts -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Page Content --}}
            <main>
                @if(isset($slot))
                {{ $slot }}
                @else
                    @yield('content')
                @endif

            </main>
        </div>
    @stack('scripts-body')
    </body>
</html>
