@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}" />
@endsection

@section('content')
@if(Auth::check())
<h2 class="username">{{ Auth::user()->name }}さん</h2>
<div class="message__wrap">
    <div class='message-box'>
        <p class="message">現在、仮登録状態です</p>
        <p class="message">【{{ Auth::user()->email }}】宛てに送信された確認メールのリンクから、本登録を完了させてください</p>
    </div>
    <div class="retransmission-box">
        <form action="/email/verification-notification" method="post">
            @csrf
            <p class="message">確認メールの再送リクエストは
                <button type="submit">こちら</button>
                から
            </p>
        </form>
        @if(session('message'))
        <p>{{ session('message') }}</p>
        @endif
    </div>
</div>
@endif
@endsection