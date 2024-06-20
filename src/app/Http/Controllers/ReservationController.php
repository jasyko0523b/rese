<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function reserve(Request $request){
        $reservation = [
            'shop_id' => $request->shop_id,
            'user_id' => $request->user_id,
            'date' => date('Y/m-d H:i:s', strtotime($request->date . ' ' . $request->time . ':00')),
            'number' => $request->number
        ];
        Reservation::create($reservation);
        return view('done');
    }
}
