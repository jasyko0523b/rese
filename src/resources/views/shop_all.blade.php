@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
@endsection

@section('content')
<div class="search-box">
    <form action="">
        <select name="" id="">
            <option value="">東京</option>
            <option value="">大阪府</option>
        </select>
        <select name="" id="">
            <option value="">寿司</option>
            <option value="">焼肉</option>
        </select>
        <input type="text" placeholder="Search...">
    </form>
</div>
<div class="shop-card-area">
    <div class="shop-card">
        <img class="card-img" src="{{ asset('img/sushi.jpg')}}" alt="" srcset="">
        <div class="card-text">
            <h3 class="card-title">仙人</h3>
            <div class="tag-area">
                <div class="tag-item">東京都</div>
                <div class="tag-item">寿司</div>
            </div>
            <div class="card-footer">
                <button class="details-button">詳しく見る</button>
                <button class="favorite-button" name="" id="">
                </button>
            </div>
        </div>
    </div>
    <div class="shop-card">
        <img class="card-img" src="{{ asset('img/sushi.jpg')}}" alt="" srcset="">
        <div class="card-text">
            <h3 class="card-title">肉</h3>
            <div class="tag-area">
                <div class="tag-item">東京都</div>
                <div class="tag-item">寿司</div>
            </div>
            <div class="card-footer">
                <button class="details-button">詳しく見る</button>
                <button class="favorite-button" name="" id="">
                </button>
            </div>
        </div>
    </div>
</div>

@endsection