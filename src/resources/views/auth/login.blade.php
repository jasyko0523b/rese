@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('content')
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