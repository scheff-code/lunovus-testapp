<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">
        </link>
    </head>
    <body>
        <div class="container mt-5 text-center">
            @if (Route::has('login'))
                <div class="row">
                    <div class="col">
                        <h1>Lunovus Assessment</h1>
                        <div class="p-5">
                            @auth
                                <a class="btn btn-primary" href="{{ url('/tasks') }}">Dashboard</a>
                            @else
                                <h4 class="p-5">You must be logged in to access this application.</h4>
                                <a href="{{ route('login') }}" class="btn btn-primary mx-3">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                                @endif
                        @endauth
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </body>
</html>
