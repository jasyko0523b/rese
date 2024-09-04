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
                <li><a class="tab-link" href="#image">画像変更</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane" id="info">
                    <div class="shop-details-area">
                        <div class="shop-name">{{ $shop->name }}</div>
                        <img class="shop-img" src="{{ $shop->image_url }}">
                        <div class="tag-area">
                            <div class="tag__item">{{ $shop->area->name }}</div>
                            <div class="tag__item">{{ $shop->genre->name }}</div>
                        </div>
                        <div class="sentence">{{ $shop->sentence }}</div>
                    </div>
                </div>
                <div class="tab-pane" id="edit">
                    <form class="edit-area" action="/owner/shop_detail/update/text" method="post">
                        @csrf
                        <input type="hidden" name="shop_id" value="1">
                        <div class="group-row">
                            <label for="name" class="form-label">店舗名</label>
                            <input class="input-field" type="text" name="name" id="name" value="{{ $shop->name }}">
                        </div>
                        <div class="group-row">
                            <label for="area" class="form-label">エリア</label>
                            <select class="input-field" name="area" id="">
                                @foreach ($areas as $area)
                                <option value="{{ $area->id }}" @if( $shop->area->id == $area->id ) selected @endif>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="group-row">
                            <label for="genre" class="form-label">ジャンル</label>
                            <select class="input-field" name="genre" id="">
                                @foreach( $genres as $genre )
                                <option value="{{ $genre->id }}" @if( $shop->genre->id == $genre->id ) selected @endif >{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="group-row">
                            <label for="sentence" class="form-label">説明文</label>
                            <textarea class="input-field input-field--sentence" name="sentence" id="sentence">{{ $shop->sentence }}</textarea>
                        </div>
                        <div class="align-right">
                            <button class="submit-button" type="submit">更新する</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="image">
                    <form class="edit-area" action="/owner/shop_detail/update/image" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="group-row">
                            <label for="shop_img" class="form-label">画像</label>
                            <input class="input-field input-field--image" type="file" accept="image/*" name="shop_img" id="shop_img">
                        </div>
                        <div class="group-row">
                            <label>プレビュー</label>
                            <div class="image__preview">
                                <img class="shop-img" id="preview-image" src="{{ $shop->image_url }}" alt="" srcset="">
                            </div>
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
<script type="text/javascript" src="{{ asset('js/tabView.js') }}"></script>
@endsection