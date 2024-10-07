@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/shop_register.css') }}" />
@endsection

@section('content')
<div class="main-wrap">
    <div class="add-form-wrap">
        <div class="title">新規店舗CSV読み込み</div>
        <form class="csv-form" action="/admin/csv/import" method="post" enctype="multipart/form-data">
            @csrf
            <div class="group-row">
                <label for="csv" class="form-label">CSVファイル</label>
                <input class="input-field input-field--csv" type="file" accept="text/csv" name="csv" id="csv">
            </div>
                <div class="align-right">
                    @foreach($errors->all() as $error)
                    {{ $error }}<br>
                    @endforeach
                    <button class="submit-button" type="submit">読み込む</button>
                </div>
            </form>
            @if(session('message'))
            <p> {{ session('message') }}</p>
            @endif
    </div>
</div>
@endsection