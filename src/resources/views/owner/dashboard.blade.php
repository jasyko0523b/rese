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
        @if(empty($today_records))
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
    <!--
    <div id="calendar">
    </div>
-->
</div>
@endsection

@section('js')
<!--
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
<script>
    const events = [{
            id: 'a',
            title: '1名:斎藤様',
            start: '2024-07-01T12:00',
            end: '2024-07-01T15:00'
        },
        {
            id: 'c',
            title: '田中様',
            start: '2024-07-01'
        },
        {
            id: 'b',
            title: '高橋様',
            start: '2024-07-03'
        }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridDay'
            },
            views: {
                timeGridDay: {
                    slotMinTime: '07:00',
                    slotMaxTime: '23:00',
                    slotLabelFormat: {
                        hour12: false,
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false,
                    },
                }
            },
            events: events,
            eventColor: '#28A745',
            eventDisplay: 'block',
            eventTimeFormat: {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            },
        });
        calendar.render();
    });
</script>
-->
@endsection