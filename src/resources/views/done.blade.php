@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}" />
@endsection

@section('content')
<div class='message-box'>
    <p class="message">ご予約ありがとうございます</p>
    <button class="back-button">戻る</button>
</div>
@endsection