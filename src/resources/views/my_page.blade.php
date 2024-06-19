@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
@endsection

@section('content')
<h2 class="username">{{ $auth->name }}さん</h2>
<div class="flexbox">
    <div class="reservation-container">
        <h3>予約状況</h3>
        <div class="reservation__item">
            <div class="reservation__header">
                <div class="reservation__name">予約１</div>
                <button class="chancel-button"></button>
            </div>
            <div class="table__wrap">
                <table class="reservation__table">
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
        @foreach($favorite as $shop)
        <div class="shop-card-area">
            <div class="shop-card">
                <img class="card-img" src="{{ $shop->image_url }}" alt="" srcset="">
                <div class="card-text">
                    <h3 class="card-title">{{$shop->name}}</h3>
                    <div class="tag-area">
                        <div class="tag-item">{{$shop->area}}</div>
                        <div class="tag-item">{{$shop->genre}}</div>
                    </div>
                    <div class="card-footer">
                        <button class="details-button">詳しく見る</button>
                        <form action="/favorite" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}" />
                            <button class="favorite-button" type="submit" name="" id="">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection