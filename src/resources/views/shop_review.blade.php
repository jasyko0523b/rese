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
            <textarea class="comment" name="comment" id="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">@if($my_review){{$my_review->comment}}@endif</textarea>
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
    /*  */

    const ratingStarDiv = document.querySelector('.rating-star');
    <?php if ($my_review) { ?>;
            [...ratingStarDiv.children].forEach((rate) => {
                if (rate.value == '{{$my_review->rank}}') {
                    rate.checked = true;
                }
            });
    <?php } ?>
</script>

<script>
    // 文字数カウント
    const maxLength = 400;
    const comment = document.querySelector('.comment');
    const textCount = document.querySelector('.text-count');
    textCount.innerHTML = '0/' + maxLength + ' (最高文字数)';
    comment.addEventListener('input', (ele) => {
        const currentLength = ele.currentTarget.value.length;
        textCount.innerHTML = currentLength + '/' + maxLength + '(最高文字数)';
        if (currentLength > maxLength) {
            textCount.style.color = 'red';
        } else {
            textCount.style.removeProperty('color');
        }
    });
</script>

<script>
    const dropArea = document.querySelector('.drop-area');

    // ドロップエリアをクリックした際のインプットのクリックイベント
    dropArea.addEventListener('click', () => {
        const reviewImg = document.querySelector('.review-img');
        reviewImg.click();
    });
</script>
<script>
    const reviewImg = document.querySelector('.review-img');

    // ドロップ時のファイル読み込み
    function dropHandler(ev) {
        const changeEv = new Event('change');

        ev.preventDefault();
        if (ev.dataTransfer.items) {
            const dt = new DataTransfer();
            [...ev.dataTransfer.items].forEach((item, i) => {
                if (item.kind == 'file') {
                    const file = item.getAsFile();
                    dt.items.add(file);
                }
            });
            reviewImg.files = dt.files;
            reviewImg.dispatchEvent(changeEv);

        } else {
            reviewImg.files = ev.dataTransfer.files;
            reviewImg.dispatchEvent(changeEv);
        }
    }

    function dragOverHandler(ev) {
        ev.preventDefault();
    }
</script>
<script>
    /* 選択ファイルの件数・拡張子チェック */
    /* 画像のプレビュー */
    const maxFiles = 1;
    const allowExtensions = '.(jpeg|jpg|png)$';
    var previewArea = document.querySelector(".preview-area");

    reviewImg.addEventListener("change", (ele) => {
        // プレビュー画像の削除
        while (previewArea.firstChild) {
            previewArea.removeChild(previewArea.firstChild);
        }
        // 件数チェック
        if (ele.target.files.length > maxFiles) {
            reviewImg.files = new DataTransfer().files;
            numberAlert();
            return;
        }
        // 拡張子チェック
        [...ele.target.files].forEach((file, i) => {
            if (!file.name.match(allowExtensions)) {
                reviewImg.files = new DataTransfer().files;
                extensionAlert();
                return;
            }
        });
        // プレビュー画像の追加
        [...ele.target.files].forEach((file, i) => {
            let img_element = document.createElement('img');
            img_element.src = URL.createObjectURL(file);
            img_element.className = 'preview-img';
            previewArea.appendChild(img_element);
        });
    });

    /* アラート */
    //拡張子エラー
    function extensionAlert() {
        alert('jpeg、pngのみアップロード可能です');
    }
    // 件数エラー
    function numberAlert() {
        alert('画像の追加は' + maxFiles + '件のみ可能です');
    }
</script>
@endsection