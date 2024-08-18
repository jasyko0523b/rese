@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}" />
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
            <div class=" input-wrap email__wrap">
                <input type="text" name="password" id="password" placeholder="Password">
            </div>
            <div class="submit-button__wrap">
                <button class="submit-button" id="submit" type="submit">新規登録</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('aside')
<ul>
    <li><a href="/admin/dashboard">店舗一覧</a></li>
    <li><a href="/admin/shop_register">店舗登録</a></li>
    <li><a href="/">ログアウト</a></li>
</ul>
@endsection