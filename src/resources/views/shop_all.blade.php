@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_all.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
@endsection

@section('content')
<a href="#">
    <div id="page-top"></div>
</a>
<div class="sort-box">
    <select class="sort-select" name="sort" id="" required>
        <option value="" hidden>並び替え方法</option>
        <option value="default">デフォルト</option>
        <option value="random">ランダム</option>
        <option value="desc">評価が高い順</option>
        <option value="asc">評価が低い順</option>
    </select>
</div>
<div class="search-box">
    <form action="/" method="post">
        @csrf
        <select name="area" id="">
            <option value="" @if(request()->input('area') == "" ) selected @endif>All area</option>
            @foreach ($areas as $area)
            <option value="{{ $area->id }}" @if( request()->input('area') == $area->id ) selected @endif>{{ $area->name }}</option>
            @endforeach
        </select>
        <select name="genre" id="">
            <option value="" @if(request()->input('genre') == "" ) selected @endif>All genre</option>
            @foreach( $genres as $genre )
            <option value="{{ $genre->id }}" @if( request()->input('genre') == $genre->id ) selected @endif >{{ $genre->name }}</option>
            @endforeach
        </select>
        <div class="input-text-wrap">
            <input type="text" name="text" placeholder="Search..." value='{{ request()->input("text") }}'>
        </div>
        <div>
            <button class="submit-button" type="submit">検索</button>
        </div>
    </form>
</div>
@isset($message)
<div class="message-area">
    <p>{{ $message }}</p>
</div>
@endisset
<div class="shop-card-area">
    @foreach ($shops as $shop)
    @if($shop->name != '新規店舗')
    <div class="shop-card">
        @if($shop->image_url != null)
        <img class="card-img" src="{{ $shop->image_url }}" alt="" srcset="">
        @else
        <div class="card-img card-img--null">画像はありません</div>
        @endif
        <div class="card-text">
            <h3 class="card-title">{{ $shop->name }}</h3>
            <div class="shop-id" hidden>{{ $shop->id }}</div>
            <div class="score">{{ $shop->averageRating() }}</div>
            <div class="tag-area">
                <div class="tag-item">{{ $shop->area->name }}</div>
                <div class="tag-item">{{ $shop->genre->name }}</div>
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
                            @endif
                </form>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection
@section('js')
<script>
    var shopCardArea = document.querySelector('.shop-card-area');
    var cardList = document.getElementsByClassName('shop-card');
    var cardArray = Array.prototype.slice.call(cardList);

    var sortingMethod = document.querySelector('.sort-select');
    sortingMethod.addEventListener('change', function() {
        switch (this.value) {
            case 'default':
                cardArray.sort(idAsc);
                break;
            case 'random':
                shuffle(cardArray);
                break;
            case 'desc':
                cardArray.sort(scoreDesc);
                break;
            case 'asc':
                cardArray.sort(scoreAsc);
                break;
        }
        for (var i = 0; i < cardArray.length; i++) {
            shopCardArea.appendChild(shopCardArea.removeChild(cardArray[i]));
        }
    });

    function idAsc(a, b) {
        idA = Number(a.querySelector('.shop-id').textContent);
        idB = Number(b.querySelector('.shop-id').textContent);
        if (idA > idB) {
            return 1;
        } else if (idA < idB) {
            return -1;
        } else {
            return 0;
        }
    }


    function scoreDesc(a, b) {
        scoreA = a.querySelector('.score').textContent;
        scoreB = b.querySelector('.score').textContent;
        if (scoreA < scoreB) {
            return 1;
        } else if (scoreA > scoreB) {
            return -1;
        } else {
            return 0;
        }
    }

    function scoreAsc(a, b) {
        scoreA = a.querySelector('.score').textContent;
        scoreB = b.querySelector('.score').textContent;
        if (scoreA == 0) {
            return 1;
        }
        if (scoreA > scoreB) {
            return 1;
        } else if (scoreA < scoreB) {
            return -1;
        } else {
            return 0;
        }
    }

    function shuffle(arr) {
        for (var i = arr.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
    }
</script>
@endsection