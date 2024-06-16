@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
@endsection

@section('content')
<h2 class="username">testさん</h2>
<div class="flexbox">
    <div class="registration-container">
        <h3>予約状況</h3>
        <div class="registration__item">
            <div class="registration__header">
                <div class="registration__name">予約１</div>
                <button class="chancel-button"></button>
            </div>
            <div class="table__wrap">
                <table class="registration__table">
                    <tr>
                        <th>Shop</th>
                        <td>仙人</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>2021-04-01</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>17:00</td>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <td>1人</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <div class="favorite-container">
        <h3>お気に入り店舗</h3>
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
    </div>
</div>

@endsection