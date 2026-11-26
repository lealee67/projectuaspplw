<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Archamp') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    ARCHAMP
                </a>

                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#tentang">Tentang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#fitur">Fitur</a>
                            </li>
                        @else

                            @if (session('user_role') === 'Peserta')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('peserta.dashboard') }}">Dashboard</a>
                                </li>

                            @elseif (session('user_role') === 'Panitia')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('panitia.dashboard') }}">Dashboard</a>
                                </li>

                                @if (Route::has('games.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('games.index') }}">Kelola Game</a>
                                    </li>
                                @endif

                                @if (Route::has('kategori-kompetisi.index'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('kategori-kompetisi.index') }}">Kategori Kompetisi</a>
                                    </li>
                                @endif
                            @endif
                        @endguest

                    </ul>

                    <ul class="navbar-nav ms-auto">

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrasi</a>
                                </li>
                            @endif

                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->nama }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form"
                                        action="{{ route('logout') }}"
                                        method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
