<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>

<body>
    <h1>QR作成</h1>
    <form action={{ route('qr') }} method="post">
        @csrf
        <input type="text" name="url" />
        <button type="submit">作成</button>
    </form>
    <p>{{ $url ?? '' }}</p>
    @isset($path)
    <img src={{ route('qr.download', ['path' => $path]) }} alt="QRコード" />
    <a href={{ route('qr.download', ['path' => $path, 'download' => true]) }}>ダウンロード</a>
    @endisset
</body>

</html>