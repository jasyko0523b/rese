@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/login.css') }}" />
<link rel="stylesheet" href="{{ asset('css/owner/dashboard.css') }}" />
@endsection

@section('content')
<div class="wrap">
    <div class="todays-event-container">
        <h2>本日のご予約一覧</h2>
        @if(empty($today_records))
        <p>本日、ご予約はありません</p>
        @else
        <table class="reservations__table">
            <tr>
                <th>日付</th>
                <th>時間</th>
                <th>人数</th>
                <th>予約者氏名</th>
            </tr>
            @foreach( $today_records as $record )
            <tr>
                <td class="reservation__data">{{ $record['date'] }}</td>
                <td class="reservation__data">{{ $record['time']}}</td>
                <td class="reservation__data">{{ $record['number'] }}名</td>
                <td class="reservation__data reservation__data--right">{{ $record['user_name'] }}　様</td>
            </tr>
            @endforeach
            @endif
        </table>
        <h2>明日以降のご予約一覧</h2>
        @if(empty($future_records))
        <p>明日以降、ご予約はありません</p>
        @else
        <table class="reservations__table">
            <tr>
                <th>日付</th>
                <th>時間</th>
                <th>人数</th>
                <th>予約者氏名</th>
            </tr>
            @foreach( $future_records as $record )
            <tr>
                <td class="reservation__data">{{ $record['date'] }}</td>
                <td class="reservation__data">{{ $record['time']}}</td>
                <td class="reservation__data">{{ $record['number'] }}名</td>
                <td class="reservation__data reservation__data--right">{{ $record['user_name'] }}　様</td>
            </tr>
            @endforeach
        </table>
        @endif
        <hr>
        <h2>過去のご予約履歴（降順）</h2>
        @if(empty($past_records))
        <p>過去のご予約はありません</p>
        @else
        <table class="reservations__table">
            <tr>
                <th>日付</th>
                <th>時間</th>
                <th>人数</th>
                <th>予約者氏名</th>
            </tr>
            @foreach( $past_records as $record )
            <tr>
                <td class="reservation__data">{{ $record['date'] }}</td>
                <td class="reservation__data">{{ $record['time']}}</td>
                <td class="reservation__data">{{ $record['number'] }}名</td>
                <td class="reservation__data reservation__data--right">{{ $record['user_name'] }}　様</td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
</div>
@endsection

