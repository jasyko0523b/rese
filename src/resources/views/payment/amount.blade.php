@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment/amount.css') }}" />
@endsection

@section('content')
<div class="amount-box">
    @can('owner')
    <form action="{{ route('payment.create') }}" method="post">
        @csrf
        <div>
            <label for="amount">金額</label>
            <input type="number" name="amount" id="amount">
        </div>
        <button type="submit" class="submit-button">決済情報入力へ</button>
    </form>
    @endcan
</div>
@endsection