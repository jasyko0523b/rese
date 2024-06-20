@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content-wrap">
    <div class="shop-details-area">
        <button class="back-button" onclick="history.back()">＜</button>
        <div class="shop-name">{{ $shop->name }}</div>
        <img class="shop-img" src="{{ $shop->image_url }}">
        <div class="tag-area">
            <div class="tag__item">{{ $shop->area }}</div>
            <div class="tag__item">{{ $shop->genre }}</div>
        </div>
        <div class="sentence">{{ $shop->sentence }}</div>
    </div>
    <form class="reservation-area" action="/reserve" method="post">
        @csrf
        <h2>予約</h2>
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="date" name="date" id="date"><br>
        <select name="time" id="time">
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
        </select><br>
        <select name="number" id="number">
            <option value="1">1人</option>
            <option value="2">2人</option>
            <option value="3">3人</option>
        </select>
        <div class="confirmation__table-wrap">
            <table class="confirmation__table">
                <tr>
                    <th>Shop</th>
                    <td>{{ $shop->name }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td id="date_view">{{ date('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td id="time_view">17:00</td>
                </tr>
                <tr>
                    <th>Number</th>
                    <td id="number_view">1人</td>
                </tr>
            </table>
        </div>
        <button class="submit-button" type="submit">予約する</button>
    </form>
</div>

@endsection

@section('js')
<script>
    document.getElementById('date').addEventListener('change', function() {
        document.getElementById('date_view').textContent = this.value;
    });
    document.getElementById('time').addEventListener('change', function() {
        document.getElementById('time_view').textContent = this.value;
    });
    document.getElementById('number').addEventListener('change', function() {
        document.getElementById('number_view').textContent = this.value + '人';
    });
    document.getElementById('date').value = new Date().toLocaleDateString('sv-SE');
</script>

@endsection