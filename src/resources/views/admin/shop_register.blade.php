@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/shop_register.css') }}" />
@endsection

@section('content')
<div class="main-wrap">
    <div class="add-form-wrap">
        <div class="title">新規店舗登録</div>
        <form class="add-owner-form" action="/admin/add" method="post">
            @csrf
            <div class="group-row">
                <label for="shop_name" class="form-label">店舗名</label>
                <input class="input-field" type="text" name="shop_name" id="shop_name">
            </div>
            <div class="group-row">
                <label for="email" class="form-label">メール</label>
                <input class="input-field" type="email" name="email" id="email">
            </div>
            <div class="group-row">
                <label for="password" class="form-label">パスワード</label>
                <input class="input-field" type="password" name="password" id="password">
            </div>
            <div class="group-row">
                <label for="area" class="form-label">エリア</label>
                <select class="input-field" name="area" id="area">
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}" @if($loop->index == 0) selected @endif>{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="group-row">
                <label for="genre" class="form-label">ジャンル</label>
                <select class="input-field" name="genre" id="genre">
                    @foreach($genres as $genre )
                    <option value="{{ $genre->id }}" @if($loop->index == 0) selected @endif>{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="align-right">
                @foreach($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
                <button class="submit-button" type="submit">新規作成</button>
            </div>
        </form>
        @if(session('message'))
        <p> {{ session('message') }}</p>
        @endif
    </div>
</div>
@endsection