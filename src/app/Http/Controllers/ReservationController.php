<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;

use App\Models\Shop;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function my_page(Request $request)
    {
        $reservations = Reservation::where('user_id', Auth::user()->id)->get();
        $favorite = Shop::whereIn('id', Auth::user()->favorite)->get();
        return view('my_page', compact('favorite', 'reservations'));
    }

    public function index(Request $request)
    {
        $reservations = Auth::user()->shop->reservations;
        $today = strtotime(now()->format('Y-m-d'));
        $today_records = [];
        $future_records = [];
        $past_records = [];
        foreach ($reservations as $reserve) {
            $record = [
                'date' => $reserve->getDateString(),
                'time' => $reserve->getTimeString(),
                'number' => $reserve->number,
                'user_name' => $reserve->user->name,
            ];
            if ($today > strtotime($record['date'])) {
                array_push($past_records, $record);
            } elseif ($today == strtotime($record['date'])) {
                array_push($today_records, $record);
            } else {
                array_push($future_records, $record);
            }
        }
        array_multisort(
            $past_records,
            SORT_DESC
        );
        return view(
            'owner.dashboard',
            compact('past_records', 'today_records', 'future_records')
        );
    }

    public function create(ReservationRequest $request)
    {
        Reservation::create([
            'shop_id' => $request->shop_id,
            'user_id' => $request->user_id,
            'date' => $request->date_time,
            'number' => $request->number
        ]);
        return view('done');
    }

    public function update(ReservationRequest $request)
    {
        $reservation = Reservation::find($request->id);
        $reservation->update(
            [
                'date' => $request->date_time,
                'number' => $request->number,
            ]
        );
        return redirect('mypage');
    }

    public function delete(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予約を削除しました');
    }
}
