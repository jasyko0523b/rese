@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
<div class="registration-box">
    <div class="title">Registration</div>
    <form class="register-form">
        <div class=" input-wrap username__wrap">
            <input type="namespace" name="" id="name" placeholder="Username">
        </div>
        <div class=" input-wrap email__wrap">
            <input type="email" name="" id="email" placeholder="Email">
        </div>
        <div class=" input-wrap password__wrap">
            <input type="password" name="" id="password" placeholder="Password">
        </div>
        <div class="submit-button__wrap">
            <button class="submit-button" id="submit" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection