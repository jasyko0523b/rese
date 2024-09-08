@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
@endsection

@section('content')
<h2 class="username">{{ Auth::user()->name }}さん</h2>
<div class="flexbox">
    <div class="reservation-container">
        <h3>予約状況</h3>
        @if(session('message'))
        <div>
            <p> {{ session('message') }}</p>
        </div>
        @endif
        <div class="reservation-card-area">
            @foreach($errors->all() as $error)
            <div class="reservation__error">
                {{ $error }}
            </div>
            @endforeach
            @if($reservations->isEmpty())
            <p>予約はありません</p>
            @else
            @foreach ($reservations as $reservation)
            <div class="reservation-card">
                <div class="reservation__header">
                    <div class="reservation__name">予約 {{ $loop->index  + 1}}</div>
                    <form action="/reservation/delete" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $reservation->id }}" />
                        <button type="submit" class="chancel-button"></button>
                    </form>
                </div>
                <div class="table__wrap">
                    <table class="reservation__table">
                        <tr>
                            <th>Shop</th>
                            <td>{{$reservation->shop->name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td class="date">{{$reservation->getDateString()}}</td>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <td class="time">{{$reservation->getTimeString()}}</td>
                        </tr>
                        <tr>
                            <th>Number</th>
                            <td class="number">{{$reservation->number}}人</td>
                        </tr>
                    </table>
                    <button class="edit-button"></button>
                    <form action="/reservation/qr" method="post">
                        @csrf
                        <input type="hidden" name="url" value="{{ route('reservation_info', ['reservation_id' => $reservation->id ]) }}" />
                        <button class="qr-button" type="submit"></button>
                    </form>
                </div>
                <form class="edit-form" action="/reservation/update" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                    <input type="hidden" name="shop_id" value="{{ $reservation->shop->id }}">
                    <input type="hidden" name="user_id" value="{{ $reservation->user->id }}">
                    <div class="group-row">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" value="{{ $reservation->getDateString() }}" required>
                    </div>
                    <div class="group-row">
                        <label for="time">Time</label>
                        <select name="time" id="time">
                            <option value="17:00" @if( $reservation->getTimeString() == '17:00' ) selected @endif>17:00</option>
                            <option value="18:00" @if( $reservation->getTimeString() == '18:00' ) selected @endif>18:00</option>
                            <option value="19:00" @if( $reservation->getTimeString() == '19:00' ) selected @endif>19:00</option>
                            <option value="20:00" @if( $reservation->getTimeString() == '20:00' ) selected @endif>20:00</option>
                        </select>
                    </div>
                    <div class="group-row">
                        <label for="number">Number</label>
                        <select name="number" id="number">
                            <option value="1" @if( $reservation->number == '1' ) selected @endif>1人</option>
                            <option value="2" @if( $reservation->number == '2' ) selected @endif>2人</option>
                            <option value="3" @if( $reservation->number == '3' ) selected @endif>3人</option>
                            <option value="4" @if( $reservation->number == '4' ) selected @endif>4人</option>
                            <option value="5" @if( $reservation->number == '5' ) selected @endif>5人</option>
                            <option value="6" @if( $reservation->number == '6' ) selected @endif>6人</option>
                        </select>
                    </div>
                    <button class="submit-button" type="submit">予約を修正する</button>
                </form>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="favorite-container">
        <h3>お気に入り店舗</h3>
        <div class="shop-card-area">
            @if($favorite->isEmpty())
            <p>お気に入りはありません</p>
            @else
            @foreach($favorite as $shop)
            <div class="shop-card">
                <img class="card-img" src="{{ $shop->image_url }}" alt="" srcset="">
                <div class="card-text">
                    <h3 class="card-title">{{$shop->name}}</h3>
                    <div class="tag-area">
                        <div class="tag-item">{{$shop->area->name}}</div>
                        <div class="tag-item">{{$shop->genre->name}}</div>
                    </div>
                    <div class="card-footer">
                        <button class="details-button" onclick="location.href='/detail/{{ $shop->id }}'">詳しく見る</button>
                        <form action="/favorite" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}" />
                            @if( in_array($shop->id, Auth::user()->favorite) )
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
            @endif
        </div>
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript" src="{{ asset('js/reservationEditButton.js') }}"></script>
@endsection