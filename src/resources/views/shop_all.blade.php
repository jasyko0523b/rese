@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
@endsection

@section('content')
<div class="search-box">
    <form action="/" method="post">
        @csrf
        <select name="area" id="">
            <option value="">All area</option>
            @foreach ($areas as $area)
            <option value="{{ $area->area }}">{{ $area->area }}</option>
            @endforeach
        </select>
        <select name="genre" id="">
            <option value="" selected>All genre</option>
            @foreach( $genres as $genre )
            <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
            @endforeach
        </select>
        <div class="input-text-wrap">
            <input type="text" name="searchbox" placeholder="Search...">
        </div>
    </form>
</div>
<div class="shop-card-area">
    @foreach ($shops as $shop)
    @if($shop->name != '新規店舗')
    <div class="shop-card">
        <img class="card-img" src="{{ $shop->image_url }}" alt="" srcset="">
        <div class="card-text">
            <h3 class="card-title">{{ $shop->name }}</h3>
            <div class="tag-area">
                <div class="tag-item">{{ $shop->area }}</div>
                <div class="tag-item">{{ $shop->genre }}</div>
            </div>
            <div class="card-footer">
                <button class="details-button" onclick="location.href='/detail/{{ $shop->id }}'">詳しく見る</button>
                <form action="/favorite" method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}" />
                    @if(Auth::check())
                        @if( in_array($shop->id, Auth::user()->favorite) )
                        <button class="favorite-button is-active" type="submit" name="" id="">
                        @else
                        <button class="favorite-button" type="submit" name="" id="">
                        @endif
                    @else
                        <button class="favorite-button" type="submit" name="" id="">
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection
