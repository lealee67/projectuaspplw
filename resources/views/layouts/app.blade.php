
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ARCHAMP')</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .archamp-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background-color: white;
            border-bottom: 1px solid #ddd;
        }

        .archamp-nav .logo {
            font-size: 22px;
            font-weight: bold;
            color: #17365D;
            text-decoration: none;
        }

        .archamp-nav .menu {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .archamp-nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .archamp-nav a:hover {
            color: #F4B942;
        }

        .archamp-header {
            background-color: #17365D;
            color: white;
            padding: 20px 40px;
        }

        .archamp-header h2 {
            letter-spacing: 2px;
        }

        .archamp-main {
            padding: 30px 40px;
        }
    </style>
</head>

<body>

    <div id="app">

        <nav class="archamp-nav">
            <a href="{{ url('/') }}" class="logo">ARCHAMP</a>

            <div class="menu">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/#tentang') }}">Tentang</a>
                <a href="{{ url('/#fitur') }}">Fitur</a>

                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}">Login</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @else
                    <span>{{ Auth::user()->nama }}</span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @endguest
            </div>
        </nav>

        <header class="archamp-header">
            <h2>ARCHAMP</h2>
            <p>Esports Tournament Management</p>
        </header>

        <main class="archamp-main">
            @yield('content')
        </main>

    </div>

</body>
</html>
