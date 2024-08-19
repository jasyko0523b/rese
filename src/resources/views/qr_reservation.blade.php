@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/qr_reservation.css') }}" />
@endsection

@section('content')
<div class='message-box'>
    <p class="message">下記のコードをお店の人に見せてください</p>
    @isset($path)
    <img src={{ route('qr.download', ['path' => $path]) }} alt="QRコード" />
    @endisset
    <button class="back-button" onclick="history.back()">戻る</button>
</div>
@endsection