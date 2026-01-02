<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
    </head>
    <body class="p-4">
        @if (Route::has('login'))
            <div class="text-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <h1 class="pb-2 mb-3 font-bold border-b border-b-gray-300">
            Problemų registravimo sistema (Ticket System)
        </h1>
        <div>
            @auth
                <p>Logged in</p>
            @endauth
            @guest
                <p>Not logged in</p>
            @endguest
        </div>
    </body>
</html>