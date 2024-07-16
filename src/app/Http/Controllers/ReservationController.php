<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Shop;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $owner = $request->user();
        $shop_id = Shop::where('owner_id', $owner->id)->first()->id;
        $reservations = Reservation::where('shop_id', $shop_id)->get();
        $records = [];
        foreach ($reservations as $reserve) {
            array_push($records, [
                'date' => date('Y/m/d', strtotime($reserve->date)),
                'time' => date('H:i', strtotime($reserve->date)),
                'number' => $reserve->number,
                'user_name' => User::find($reserve->user_id)->name,
            ]);
        }
        return view('owner.dashboard', compact('records'));
    }



    public function reserve(Request $request)
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
}
