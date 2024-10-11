@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_card.css') }}" />
<link rel="stylesheet" href="{{ asset('css/shop_review.css') }}" />
@endsection

@section('content')
<div class="content-wrap">
    <div class="shop-details-area">
        <h1 class="title">今回のご利用はいかがでしたか？</h1>
        <div class="shop-card">
            @if($shop->image_url != null)
            <img class="card-img" src="{{ $shop->image_url }}" alt="" onerror="this.onerror = null;invalidImage(this);">
            @else
            <div class="card-img card-img--null">画像はありません</div>
            @endif
            <div class="card-text">
                <h3 class="card-title">{{ $shop->name }}</h3>
                <div class="shop-id" hidden>{{ $shop->id }}</div>
                <div class="tag-area">
                    <div class="tag-item">{{ $shop->area->name }}</div>
                    <div class="tag-item">{{ $shop->genre->name }}</div>
                </div>
                <div class="card-footer">
                    <button class="details-button" onclick="location.href='/detail/{{ $shop->id }}'" disabled>詳しく見る</button>
                    <form action="/favorite" method="post">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}" />
                        @if(Auth::check())
                        @if( in_array($shop->id, Auth::user()->favorite) )
                        <button class="favorite-button is-active" name="" id="" type="submit">
                            @else
                            <button class="favorite-button" name="" id="" type="submit">
                                @endif
                                @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="reviews-area">
        <form class="write-form" id="review-form" action="/detail/{{ $shop->id }}/review/create" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            @if(Auth::check())
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @endif

            <h2>体験を評価してください</h2>
            <div class="group-row">
                <div class="rating-star">
                    <input type="radio" class="star" name="rank" value="1">
                    <input type="radio" class="star" name="rank" value="2">
                    <input type="radio" class="star" name="rank" value="3" checked>
                    <input type="radio" class="star" name="rank" value="4">
                    <input type="radio" class="star" name="rank" value="5">
                </div>
            </div>
            <h2>口コミを投稿</h2>
            <textarea class="comment" name="comment" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">
@if(old('comment')){{ old('comment') }}@else
@if($my_review){{$my_review->comment}}@endif
@endif</textarea>
            <div class="align-right">
                <div class="text-count"></div>
            </div>
            <h2>画像の追加</h2>
            <div class="preview-area">
                <img class="preview-img" id="preview-img" @if($my_review) src="{{$my_review->image_url}}" @endif alt="">
            </div>
            <div class="drop-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                <input type="file" accept=".jpeg,.jpg,.png" class="review-img" name="review_img" id="review-img" hidden>
                <p class="drop-area__message drop-area__message--click">クリックして写真を追加</p>
                <p class="drop-area__message drop-area__message--drop">またはドラッグアンドドロップ</p>
            </div>
            <div class="image-delete__container">
                <label for="image-delete-check">
                    <input type="checkbox" class="image-delete-check" name="image_delete_check" id="image-delete-check">
                    画像を削除する
                </label>
            </div>
        </form>
        <ul>
            @foreach($errors->review->all() as $error)
            <li>
                {{ $error }}
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="submit-area">
    <button class="review-submit-button" type="submit" form="review-form">口コミを投稿</button>
</div>

@endsection

@section('js')
<script>
    const ratingStarDiv = document.querySelector('.rating-star');
    <?php if (old('rank')) { ?>
            [...ratingStarDiv.children].forEach((rate) => {
                if (rate.value == "{{old('rank')}}") {
                    rate.checked = true;
                }
            });
    <?php } else if ($my_review) { ?>;
        [...ratingStarDiv.children].forEach((rate) => {
            if (rate.value == '{{$my_review->rank}}') {
                rate.checked = true;
            }
        });
    <?php } ?>
</script>
<script type="text/javascript"
    src="{{ asset('js/textCounter.js') }}">
</script>
<script type="text/javascript"
    src="{{ asset('js/dropImage.js') }}">
</script>
<script type="text/javascript" src="{{ asset('js/invalidImage.js') }}"></script>
@endsection