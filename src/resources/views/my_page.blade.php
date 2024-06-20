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
        <div class="reservation-card-area">
            @foreach ($reserveList as $reserve)
            <div class="reservation-card">
                <div class="reservation__header">
                    <div class="reservation__name">予約 {{ $loop->index  + 1}}</div>
                    <button class="chancel-button"></button>
                </div>
                <div class="table__wrap">
                    <table class="reservation__table">
                        <tr>
                            <th>Shop</th>
                            <td>{{$reserve['shop_name']}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$reserve['date']}}</td>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <td>{{$reserve['time']}}</td>
                        </tr>
                        <tr>
                            <th>Number</th>
                            <td>{{$reserve['number']}}人</td>
                        </tr>
                    </table>

                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="favorite-container">
        <h3>お気に入り店舗</h3>
        <div class="shop-card-area">
            @foreach($favorite as $shop)
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
                            @if( in_array($shop->id, $auth->favorite) )
                            <button class="favorite-button is-active" type="submit" name="" id="">
                            </button>
                            @else
                            <button class="favorite-button" type="submit" name="" id="">
                            </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection