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
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/side.css') }}" />
    @yield('css')
</head>

<body>
    <div class="wrapper">
        <main>
            @yield('content')
        </main>
        <aside>
            <div class="side-content">
                <a href=" /" class="site-title nunito-font">Rese</a>
            </div>
            <div class="menu-wrapper">
                <ul>
                    @can('admin')
                    <li><a href="/admin/dashboard">店舗一覧</a></li>
                    <li><a href="/admin/shop_register">店舗登録</a></li>
                    <li><a href="/admin/email">メール一斉送信</a></li>
                    @endcan
                    @can('owner')
                    <li><a href="/owner/dashboard">予約一覧</a></li>
                    <li><a href="/owner/shop_detail">店舗情報</a></li>
                    @endcan
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</body>
@yield('js')

</html>