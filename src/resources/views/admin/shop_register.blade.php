@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/shop_register.css') }}" />
@endsection

@section('content')
<div class="main-wrap">
    <div class="add-form-wrap">
        <div class="title">新規店舗登録</div>
        <form class="add-owner-form" action="/admin/add" method="post">
            @csrf
            <div class="input-wrap store-name__wrap">
                <input type="text" name="shop_name" id="shop_name" placeholder="Shop name">
            </div>
            <div class=" input-wrap email__wrap">
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <div class=" input-wrap password__wrap">
                <input type="text" name="password" id="password" placeholder="Password">
            </div>
            <div class="submit-button__wrap">
                <button class="submit-button" id="submit" type="submit">新規登録</button>
            </div>
        </form>
    </div>
</div>
@endsection