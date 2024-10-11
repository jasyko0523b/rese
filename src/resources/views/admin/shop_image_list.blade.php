@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/shop_image_list.css') }}" />
@endsection

@section('content')
<div class="main-wrap">
    <div class="form-title">店舗画像アップロード</div>
    <form class="image-form" action="/admin/shop_image/upload" method="post" enctype="multipart/form-data">
        @csrf
        <div class="group-row">
            <input class="input-field" type="file" accept=".jpg,.jpeg,.png" name="image_file[]" id="image_file" multiple>
        </div>
        @foreach($errors->all() as $error)
        <div class="error-message">
            {{ $error }}
        </div>
        @endforeach
        <div class="align-right">
            <button class="submit-button" type="submit">読み込む</button>
        </div>
        @if(session('message'))
        <p> {{ session('message') }}</p>
        @endif
    </form>
    <div class="image-list">
        <div>クリックでURLコピー</div>
        @foreach($image_list as $image)
        <div class="image-card">
            <div class="image-area">
                <img class="shop-img" src="{{ $image }}" alt="{{ $image }}">
            </div>
            <div class="path-text">{{$image}}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript"
    src="{{ asset('js/copyImagePath.js') }}">
</script>
@endsection