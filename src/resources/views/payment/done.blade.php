@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment/done.css') }}" />
@endsection

@section('content')
<div class='message-box'>
    @isset($message)
    <p>{{ $message }}</p>
    @endisset
    <p class="message">ご利用ありがとうございました</p>
    <form action="/" method="get">
        <button type="submit" class="back-button">サイトトップへ</button>
    </form>
</div>
@endsection