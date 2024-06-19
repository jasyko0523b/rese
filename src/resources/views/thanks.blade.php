@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
@endsection

@section('content')
<div class='message-box'>
    <p class="message">会員登録ありがとうございます</p>
    <button class="login-button">ログインする</button>
</div>
@endsection