@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/email_writing.css') }}" />
@endsection

@section('content')


<div class="content-wrap">
    <div class="card">
        <div class="card-header">
            <ul>
                <li><a class="tab-link active" href="#email">メール</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="email">
                    <div class="edit-area">
                        <form action="/admin/email/send_all" method="post">
                            @csrf
                            <div class="group-row">
                                <label for="subject">件名</label><input type="text" name="subject" id="subject" class="input-field">
                            </div>
                            <div class="group-row">
                                <label for="content">本文</label><textarea name="content" id="content" class="input-field input-field--textarea"></textarea>
                            </div>
                            <div class="align-right">
                                <button type="submit" class="submit-button">ユーザー全員に送信する</button>
                            </div>
                        </form>
                        @if(session('message'))
                        <p>{{ session('message') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection