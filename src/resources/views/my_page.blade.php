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
                            <td class="date">{{$reserve['date']}}</td>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <td class="time">{{$reserve['time']}}</td>
                        </tr>
                        <tr>
                            <th>Number</th>
                            <td class="number">{{$reserve['number']}}人</td>
                        </tr>
                    </table>
                    <button class="edit-button"></button>
                </div>
                <form class="edit-form" action="/reserve/update" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $reserve['id'] }}">
                    <div class="group-row">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" required>
                    </div>
                    <div class="group-row">
                        <label for="time">Time</label>
                        <select name="time" id="time">
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                        </select>
                    </div>
                    <div class="group-row">
                        <label for="number">Number</label>
                        <select name="number" id="number">
                            <option value="1">1人</option>
                            <option value="2">2人</option>
                            <option value="3">3人</option>
                        </select>
                    </div>
                    <button class="submit-button" type="submit">予約を修正する</button>
                </form>
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
                        <button class="details-button" onclick="location.href='/detail/{{ $shop->id }}'">詳しく見る</button>
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


@section('js')
<script>
    var reserveList = document.querySelectorAll('.reservation-card');

    reserveList.forEach((reserve, i) => {

        var dateValue = reserve.querySelector('.date').textContent;
        var timeValue = reserve.querySelector('.time').textContent;
        var numberValue = reserve.querySelector('.number').textContent;
        var dateInput = reserve.querySelector('#date');
        var timeInput = reserve.querySelector('#time');
        var numberInput = reserve.querySelector('#number');

        dateInput.value = dateValue;
        timeInput.value = timeValue;
        numberInput.value = numberValue.substr(0, numberValue.indexOf('人'));

        var editButton = reserve.querySelector('.edit-button');
        editButton.classList.add('active');
        var editForm = reserve.querySelector('.edit-form');
        if (editButton != null) {
            editButton.addEventListener('click', () => {
                editForm.classList.toggle('active');
            });
        }
    });
</script>
@endsection