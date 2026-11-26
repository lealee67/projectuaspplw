
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Archamp')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        header {
            background-color: #17365D;
            color: white;
            padding: 20px 40px;
        }

        header h2 {
            letter-spacing: 2px;
        }

        main {
            padding: 30px 40px;
        }

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: white;
    border-bottom: 1px solid #ddd;
}

nav .logo {
    font-size: 22px;
    font-weight: bold;
    color: #17365D;
}

nav .menu {
    display: flex;
    gap: 25px;
}

nav a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

nav a:hover {
    color: #F4B942;
}

    </style>
</head>
<body>


<nav>
    <div class="logo">ARCHAMP</div>

    <div class="menu">
        @guest
            <a href="/">Beranda</a>
            <a href="/#tentang">Tentang</a>
            <a href="/#fitur">Fitur</a>
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registrasi</a>
        @else
            @if (session('user_role') === 'Peserta')
                <a href="{{ route('peserta.dashboard') }}">Dashboard</a>
                <a href="#">Turnamen</a>
                <a href="#">Pendaftaran Saya</a>
                <a href="#">Jadwal Pertandingan</a>
                <a href="#">Hasil Pertandingan</a>
                <a href="#">Juara</a>

            @elseif (session('user_role') === 'Panitia')
                <a href="{{ route('panitia.dashboard') }}">Dashboard</a>
                <a href="#">Kelola Game</a>
                <a href="{{ route('kategori-kompetisi.index') }}">Kategori Kompetisi</a>
                <a href="#">Kelola Turnamen</a>
                <a href="#">Verifikasi Pendaftaran</a>
                <a href="#">Jadwal Pertandingan</a>
                <a href="#">Hasil Pertandingan</a>
                <a href="#">Penetapan Juara</a>
            @endif
        @endguest
    </div>
</nav>

    <header>
        <h2>ARCHAMP</h2>
        <p>Esports Tournament Management</p>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
