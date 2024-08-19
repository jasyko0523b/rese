<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Shop;

use App\Http\Requests\ReservationRequest;
use DateTime;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $owner = $request->user();
        $shop_id = Shop::where('owner_id', $owner->id)->first()->id;
        $reservations = Reservation::where('shop_id', $shop_id)->oldest('date')->get();
        $today = strtotime(now()->format('Y-m-d'));
        $today_records = [];
        $future_records = [];
        $past_records = [];
        foreach ($reservations as $reserve) {
            $record = [
                'date' => date('Y/m/d', strtotime($reserve->date)),
                'time' => date('H:i', strtotime($reserve->date)),
                'number' => $reserve->number,
                'user_name' => User::find($reserve->user_id)->name,
            ];
            $date= strtotime($record['date']);
            if($today > $date){
                array_push($past_records, $record);
            }elseif($today == $date){
                array_push($today_records, $record);
            }else{
                array_push($future_records, $record);
            }
        }
        array_multisort($past_records, SORT_DESC);
        return view('owner.dashboard', compact('past_records', 'today_records', 'future_records'));
    }



    public function reserve(ReservationRequest $request)
    {
        $reservation = [
            'shop_id' => $request->shop_id,
            'user_id' => $request->user_id,
            'date' => date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time . ':00')),
            'number' => $request->number
        ];
        Reservation::create($reservation);
        return view('done');
    }

    public function update(Request $request)
    {
        $reservation = Reservation::find($request->id);
        $reservation->update(
            [
                'date' =>
                date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time . ':00')),
                'number' => $request->number,
            ]
        );
        return redirect('mypage');
    }

    public function info($reservation_id){
        $reservation = Reservation::find($reservation_id);
        $reservation_info = [
                'id' => $reservation->id,
                'shop_name' => Shop::where('id', $reservation->shop_id)->first()->name,
                'date' => date('Y-m-d', strtotime($reservation->date)),
                'time' => date('H:i', strtotime($reservation->date)),
                'number' => $reservation->number,
                'updated_at' => $reservation->updated_at,
            ];

        return view('info_reservation', compact('reservation_info'));
    }
}
