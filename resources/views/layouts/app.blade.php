
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
        <a href="/">Beranda</a>
        <a href="/#tentang">Tentang</a>
        <a href="/#fitur">Fitur</a>
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
