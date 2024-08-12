@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/login.css') }}" />
@endsection

@section('content')
<div>利用者一斉送信</div>
<form action="/admin/email/send_all" method="post">
    @csrf
    <div><label for="">件名</label><input type="text" name="" id=""></div>
    <div><label for="">本文</label><input type="text"></div>
    <button type="submit">ユーザー全員に送信する</button>
</form>
@if(session('message'))
<p>{{ session('message') }}</p>
@endif
<div class="login-box">
    <div class="title">Login</div>
    <form class="login-form" action="/login" method="post">
        @csrf
        <div class=" input-wrap email__wrap">
            <input type="email" name="email" id="email" placeholder="Email">
        </div>
        <div class=" input-wrap password__wrap">
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="submit-button__wrap">
            <button class="submit-button" id="submit" type="submit">ログイン</button>
        </div>
    </form>
    @foreach($errors->all() as $error)
    {{ $error }}
    @endforeach
</div>
@endsection