@extends('layouts.side')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}" />
@endsection

@section('content')
<div class="main-wrap">
    <div class="owner-table-wrap">
        <table class="owner-table">
            <tr>
                <th class="owner-table-header owner-table-header--id">ID</th>
                <th class="owner-table-header">店舗名</th>
                <th class="owner-table-header">メール</th>
            </tr>
            @foreach ($addresses as $address)
            <tr>
                <td class="owner-table-item owner-table-item--id">{{ $address['id'] }}</td>
                <td class="owner-table-item">{{ $address['name'] }}</td>
                <td class="owner-table-item">{{ $address['email'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection

