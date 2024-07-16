@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content-wrap">
    <div class="shop-details-area">
        <button class="back-button" onclick="history.back()">＜</button>
        <div class="shop-name">{{ $shop->name }}</div>
        <img class="shop-img" src="{{ $shop->image_url }}">
        <div class="tag-area">
            <div class="tag__item">{{ $shop->area }}</div>
            <div class="tag__item">{{ $shop->genre }}</div>
        </div>
        <div class="sentence">{{ $shop->sentence }}</div>
    </div>
    <form class="reservation-area" action="/reserve" method="post">
        @csrf
        <h2>予約</h2>
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        @if(Auth::check())
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        @endif
        <input type="date" name="date" id="date"><br>
        <select name="time" id="time">
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
        </select><br>
        <select name="number" id="number">
            <option value="1">1人</option>
            <option value="2">2人</option>
            <option value="3">3人</option>
        </select>
        <div class="confirmation__table-wrap">
            <table class="confirmation__table">
                <tr>
                    <th>Shop</th>
                    <td>{{ $shop->name }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td id="date_view">{{ date('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td id="time_view">17:00</td>
                </tr>
                <tr>
                    <th>Number</th>
                    <td id="number_view">1人</td>
                </tr>
            </table>
        </div>
        <button class="reserve-submit-button" type="submit">予約する</button>
    </form>
</div>
<div class="reviews-area">
    <h4 class="reviews-top-title">口コミ評価</h4>
    <div class="reviews-top">
        <div class="reviews-average">
            <div class="reviews-average-value">
                4.5
            </div>
            <div class="reviews-average-star" style="--rate: 4.5"></div>
        </div>
        <div class="review__button-wrap">
            <button class="review__button active">レビューを書く</button>
        </div>
    </div>
    <hr>
    <div class="write-area">
        <form class="write-form" action="/review" method="post">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="group-row">
                <div class="form-label">評価</div>
                <div class="rating-star">
                    <input type="radio" class="star" name="rank" value="1">
                    <input type="radio" class="star" name="rank" value="2">
                    <input type="radio" class="star" name="rank" value="3">
                    <input type="radio" class="star" name="rank" value="4">
                    <input type="radio" class="star" name="rank" value="5">
                </div>
                <div class="selected-rank"></div>
            </div>
            <div class="group-row">
                <label for="comment" class="form-label">コメント</label>
                <textarea name="comment" id="comment"></textarea>
            </div>
            <div class="align-right">
                <button class="review-submit-button" type="submit">投稿する</button>
            </div>
        </form>
    </div>
    <div class="review-list active">
        @foreach($reviews as $review)
        <div class="review">
            <div class="review__header">
                <div class="review__header--left">
                    <div class="review__header-rank">
                        <div class="review__header-star" style="--rate: {{ $review->rank }}"></div>
                        <div class="review__header-value">{{ $review->rank . '.0' }}</div>
                    </div>
                </div>
                <div class="review__header--right">
                    <div class="review__header-date">{{ str_replace('-', '/', substr($review->created_at, 0, 10)) }}</div>
                </div>
            </div>
            <hr>
            <div class="review__comment">{{ $review->comment }}</div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@section('js')
<script>
    document.getElementById('date').addEventListener('change', function() {
        document.getElementById('date_view').textContent = this.value;
    });
    document.getElementById('time').addEventListener('change', function() {
        document.getElementById('time_view').textContent = this.value;
    });
    document.getElementById('number').addEventListener('change', function() {
        document.getElementById('number_view').textContent = this.value + '人';
    });
    document.getElementById('date').value = new Date().toLocaleDateString('sv-SE');


    var stars = document.querySelectorAll('.star');
    var selectedRank = document.querySelector('.selected-rank');
    stars.forEach((star) => {
        star.addEventListener('click', () => {
            selectedRank.textContent = '( ' + star.value + '.0 )';
        });
    });
    stars[2].click();



    var writeArea = document.querySelector('.write-area');
    var reviewList = document.querySelector('.review-list');
    var reviewButton = document.querySelector('.review__button');
    reviewButton.addEventListener('click', () => {
        reviewButton.classList.toggle('active');
        writeArea.classList.toggle('active');
        reviewList.classList.toggle('active');
    });
</script>

@endsection