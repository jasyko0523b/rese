@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment/create.css') }}" />
@endsection

@section('content')
<div class="container">
    @if (session('flash_alert'))
    <div class="alert alert-danger">{{ session('flash_alert') }}</div>
    @elseif(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="payment-card">
        <div class="card-header">Stripe決済</div>
        <div class="card-body">
            <form id="card-form" action="{{ route('payment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="amount" value="{{ $amount }}">
                <div>
                    <label for="amount">金額</label>
                    <div>{{ $amount }}円</div>
                </div>

                <div>
                    <label for="card_number">カード番号</label>
                    <div id="card-number" class="form-control"></div>
                </div>

                <div>
                    <label for="card_expiry">有効期限</label>
                    <div id="card-expiry" class="form-control"></div>
                </div>

                <div>
                    <label for="card-cvc">セキュリティコード</label>
                    <div id="card-cvc" class="form-control"></div>
                </div>

                <div id="card-errors" class="text-danger"></div>

                <button type="submit" class="submit-button">支払い</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ asset('js/stripe.js') }}"></script>
@endsection