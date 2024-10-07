@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
@endsection

@section('content')
<div class="content-wrap">
    <div class="shop-details-area">
        <button class="back-button" onclick="location.href='/'">＜</button>
        <div class="shop-name">{{ $shop->name }}</div>
        @if($shop->image_url != null)
        <img class="shop-img" src="{{ $shop->image_url }}">
        @else
        <div class="no-image">画像はありません</div>
        @endif
        <div class="tag-area">
            <div class="tag__item">{{ $shop->area->name }}</div>
            <div class="tag__item">{{ $shop->genre->name }}</div>
        </div>
        <div class="sentence">{{ $shop->sentence }}</div>
    </div>
    <form class="reservation-area" action="/reservation/create" method="post">
        @csrf
        <h2>予約</h2>
        @if( !Auth::check() || !Auth::user()->hasVerifiedEmail() )
        <div class="please-login-box">
            <p>※予約機能は本登録後にご利用いただけます</p>
        </div>
        @endif
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}"><br>
        <select name="time" id="time">
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
            <option value="20:00">20:00</option>
        </select><br>
        <select name="number" id="number">
            <option value="1">1人</option>
            <option value="2">2人</option>
            <option value="3">3人</option>
            <option value="4">4人</option>
            <option value="5">5人</option>
            <option value="6">6人</option>
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
        <ul>
            @foreach($errors->all() as $error)
            <li>
                {{ $error }}
            </li>
            @endforeach
        </ul>
        @if( Auth::check() && Auth::user()->hasVerifiedEmail() )
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button class="reserve-submit-button" type="submit">予約する</button>
        @endif
    </form>
</div>
<div class="reviews-area">
    <h4 class="reviews-top-title">口コミ評価</h4>
    <div class="reviews-top">
        <div class="reviews-average">
            @if($shop->averageRating() != 0)
            <div class="reviews-average-value">
                {{ $shop->averageRating() }}
                <div class="reviews-count">({{ count($shop->reviews) }}件)</div>
            </div>
            @else
            <div class="reviews-average--no-review">口コミがありません</div>
            @endif
            <div class="reviews-average-star" style="--rate: {{ $shop->averageRating() }}"></div>
        </div>
        <div class="review__button-wrap">
            @if( !Auth::check() || !Auth::user()->hasVerifiedEmail() )
            <p>※口コミ投稿は本登録後にご利用いただけます</p>
            @else
            @if(!$my_review)
            <button onclick="location.href='/detail/{{$shop->id}}/review'" class="review__button active">口コミを投稿する</button>
            @endif
            @endif
        </div>
    </div>
    <hr>
    <div class="review-list active">
        @if($my_review)
        <div class="my-review">
            <div class="my-review__header">
                <h3>あなたの口コミ</h3>
                <div class="my-review__header--right">
                    <div><a href="/detail/{{$shop->id}}/review" class="edit-link">
                            編集する
                        </a></div>
                    <div>
                        <form action="/detail/{{ $shop->id }}/review/delete" method="post">
                            @csrf
                            <input type="hidden" name="review_id" value="{{ $my_review->id }}">
                            <button type="submit" class="delete-button">削除する</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="review">
                <div class="review__header">
                    <div class="review__header--left">
                        <div class="review__header-rank">
                            <div class="review__header-star" style="--rate: {{ $my_review->rank }}"></div>
                            <div class="review__header-value">{{ $my_review->rank . '.0' }}</div>
                        </div>
                    </div>
                    <div class="review__header--right">
                        <div class="review__header-date">{{ str_replace('-', '/', substr($my_review->created_at, 0, 10)) }}</div>
                    </div>
                </div>
                @if($my_review->comment != null || $my_review->image_url != null)
                <hr>
                <div class="review__content">
                    @if($my_review->comment != null)
                    <div class="review__comment">
                        {{ $my_review->comment }}
                    </div>
                    @endif
                    @if($my_review->image_url != null)
                    <img src="{{$my_review->image_url}}" alt="" class="review__image">
                    @endif
                </div>
                @endif
            </div>
        </div>
        <hr>
        @endif
        @if((!$my_review&&count($shop->reviews)>0) || $my_review && count($shop->reviews)>1)
        <div class="review-list__title">全ての口コミ情報</div>
        @endif
        @foreach($shop->reviews->reverse() as $review)
        @if((!Auth::check() || (Auth::check() && $review->user_id != Auth::user()->id)) && ($review->comment != null || $review->image_url != null))
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
            <div class="review__content">
                @if($review->comment != null)
                <div class="review__comment">
                    {{ $review->comment }}
                </div>
                @endif
                @if($review->image_url != null)
                <img src="{{$review->image_url}}" alt="" class="review__image">
                @endif
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/reservationInfoTable.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/reviewStar.js') }}"></script>
@endsection