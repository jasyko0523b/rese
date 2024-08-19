@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/info_reservation.css') }}" />
@endsection

@section('content')
<div class='message-box'>
    <p class="message">予約情報</p>
    <div class="table__wrap">
        <table class="reservation__table">
            <tr>
                <th>Shop</th>
                <td>{{$reservation_info['shop_name']}}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td class="date">{{$reservation_info['date']}}</td>
            </tr>
            <tr>
                <th>Time</th>
                <td class="time">{{$reservation_info['time']}}</td>
            </tr>
            <tr>
                <th>Number</th>
                <td class="number">{{$reservation_info['number']}}人</td>
            </tr>
            <tr>
                <th>Update</th>
                <td class="update">{{$reservation_info['updated_at']}}</td>
            </tr>
        </table>
    </div>
    <button class="back-button" onclick="history.back()">戻る</button>
</div>
@endsection