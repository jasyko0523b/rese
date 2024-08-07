@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content-wrap">
    <div class="card">
        <div class="card-header">
            <ul>
                <li><a class="tab-link" href="#info">店舗情報</a></li>
                <li><a class="tab-link" href="#edit">編集</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" id="info">
                    <div class="shop-details-area">
                        <div class="shop-name">{{ $shop->name }}</div>
                        <img class="shop-img" src="../img/sushi.jpg">
                        <div class="tag-area">
                            <div class="tag__item">{{ $shop->area }}</div>
                            <div class="tag__item">{{ $shop->genre }}</div>
                        </div>
                        <div class="sentence">{{ $shop->sentence }}</div>
                    </div>

                </div>
                <div class="tab-pane" id="edit">
                    <form class="edit-area" action="/owner/update" method="post">
                        @csrf
                        <input type="hidden" name="shop_id" value="1">
                        <div class="group-row">
                            <label for="name" class="form-label">店舗名</label>
                            <input type="text" name="name" id="name" value="{{ $shop->name }}">
                        </div>
                        <div class="group-row">
                            <label for="shop_img" class="form-label">画像</label>
                            <input type="text" name="shop_img" id="shop_img" value="{{ $shop->image_url }}">
                        </div>
                        <div class="group-row">
                            <label for="area" class="form-label">エリア</label>
                            <input type="text" name="area" id="area" value="{{ $shop->area }}">
                        </div>
                        <div class="group-row">
                            <label for="genre" class="form-label">ジャンル</label>
                            <input type="text" name="genre" id="genre" value="{{ $shop->genre }}">
                        </div>
                        <div class="group-row">
                            <label for="sentence" class="form-label">説明文</label>
                            <textarea name="sentence" id="sentence">{{ $shop->sentence }}</textarea>
                        </div>
                        <div class="align-right">
                            <button class="submit-button" type="submit">更新する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    var tabs = document.querySelectorAll('.tab-link');
    var pages = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            /* タグ部分の見た目の切り替え */
            if (!tab.classList.contains('active')) {
                tabs.forEach(ele => {
                    ele.classList.remove('active');
                });
                tab.classList.toggle('active');
            }

            var targetId = tab.href.substring(tab.href.indexOf('#') + 1, tab.href.length);

            pages.forEach(page => {
                if (page.id != targetId) {
                    page.classList.remove('active');
                } else {
                    page.classList.add('active');
                }
            });

        });
    });
    tabs[0].click();
</script>
@endsection