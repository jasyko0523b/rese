@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/shop_csv.css') }}" />
@endsection

@section('content')
<div class="main-wrap">
    <div class="csv-form-wrap">
        <div class="title">新規店舗CSV読み込み</div>
        <form class="csv-form" action="/admin/shop_csv/import" method="post" enctype="multipart/form-data">
            @csrf
            <div class="group-row">
                <input class="input-field input-field--csv" type="file" accept="text/csv" name="csv_file" id="csv_file">
            </div>
            @foreach($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
            <div class="align-right">
                <button class="submit-button" type="submit">読み込む</button>
            </div>
            @if(session('message'))
            <p> {{ session('message') }}</p>
            @endif
        </form>
    </div>
</div>
<h3>CSV記入例</h3>
<div><textarea class="template" name="" id="" readonly>
name,email,password,area,genre,sentence,image_url
店舗１,test1@sample.com,password1,東京都,寿司,概要１,http://localhost/image1.jpg
店舗２,test2@sample.com,password2,大阪府,焼肉,概要２,http://localhost/image2.jpeg
店舗３,test3@sample.com,password3,福岡県,イタリアン,概要３,http://localhost/image3.png
店舗４,test4@sample.com,password4,東京都,居酒屋,概要４,http://localhost/image4.jpg
店舗５,test5@sample.com,password5,東京都,ラーメン,概要５,http://localhost/image5.jpg
</textarea></div>
@endsection