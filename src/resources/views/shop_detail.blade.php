@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content-wrap">
    <div class="shop-details-area">
        <button class="back-button">＜</button>
        <div class="shop-name">仙人</div>
        <img class="shop-img" src="{{ asset('img/sushi.jpg') }}">
        <div class="tag-area">
            <div class="tag__item">東京都</div>
            <div class="tag__item">寿司</div>
        </div>
        <div class="sentence">料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。</div>
    </div>
    <form class="registration-area" action="">
        <h2>予約</h2>
        <input type="date" name="" id=""><br>
        <select name="" id="">
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
        </select><br>
        <select name="" id="">
            <option value="1">1人</option>
            <option value="2">2人</option>
            <option value="3">3人</option>
        </select>
        <div class="confirmation__table-wrap">
            <table class="confirmation__table">
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
        <button class="submit-button" type="submit">予約する</button>
    </form>
</div>

@endsection