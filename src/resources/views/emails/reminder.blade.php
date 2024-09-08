@component('mail::message')
{{ $reservation->user->name }} 様

この度は{{ config('app.name') }}をご利用いただき誠にありがとうございます。<br>
ご予約の当日になりましたので、お知らせいたします。


{{ $reservation->user->name }} 様のご予約内容は、以下の通りです。

@component('mail::panel')
<table width="100%">
    <tr>
        <th>Shop</th>
        <td>{{ $reservation->shop->name }}</td>
    </tr>
    <tr>
        <th>Date</th>
        <td>{{ $reservation->getDateString() }}</td>
    </tr>
    <tr>
        <th>Time</th>
        <td>{{ $reservation->getTimeString() }}</td>
    </tr>
    <tr>
        <th>Number</th>
        <td>{{ $reservation->number }}名様</td>
    </tr>
</table>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent