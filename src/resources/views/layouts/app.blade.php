<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <button class="menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a class="site-title" href="/">
                Rese
            </a>
        </div>
        <nav class="header__nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="/">Home</a></li>
                <li class="nav-item"><a href="/register">Registration</a></li>
                <li class="nav-item"><a href="/login">Login</a></li>
                <li class="nav-item auth"><a href="/">Logout</a></li>
                <li class="nav-item auth"><a href="/mypage">Mypage</a></li>
            </ul>

        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
<script type="text/javascript" src="{{ asset('js/header.js') }}"></script>
@yield('js')

</html>