@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
<div class="registration-box">
    <div class="title">Registration</div>
    <form class="register-form" action="/register" method="post">
        @csrf
        <div class=" input-wrap username__wrap">
            <input type="text" name="name" id="name" placeholder="Username" value="{{ old('name') }}">
        </div>
        <div class=" input-wrap email__wrap">
            <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class=" input-wrap password__wrap">
            <input type="password" name="password" placeholder="Password">
        </div>
        <div class="submit-button__wrap">
            <button class="submit-button" id="submit" type="submit">登録</button>
        </div>
        @if( $errors->has('name') )
        {{$errors->first('name')}}
        @endif
    </form>
</div>
@endsection