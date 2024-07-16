<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->user();

        $reservations = Reservation::where('user_id', $auth->id)->get();
        $reserveList = [];
        foreach ($reservations as $reserve) {
            array_push($reserveList, [
                'id' => $reserve->id,
                'shop_name' => Shop::where('id', $reserve->shop_id)->first()->name,
                'date' => date('Y-m-d', strtotime($reserve->date)),
                'time' => date('H:i', strtotime($reserve->date)),
                'number' => $reserve->number,
            ]);
        }

        $favorite = Shop::whereIn('id', $auth->favorite)->get();
        return view('my_page', compact('auth', 'favorite', 'reserveList'));
    }



    public function favorite(Request $request)
    {
        $user = $request->user();
        $favorite = $user->favorite;
        $shop_id = $request->shop_id;

        if (in_array($shop_id, $favorite)) {
            $favorite = array_diff($favorite, array($shop_id));
            $favorite = array_values($favorite);
        } else {
            array_push($favorite, $shop_id);
        }

        $user->update(['favorite' => $favorite]);

        return redirect()->back();
    }




    public function review(Request $request){
        $review = [
            'shop_id' => $request->shop_id,
            'user_id' => $request->user_id,
            'rank' => $request->rank,
            'comment' => $request->comment,
        ];
        Review::create($review);
        return redirect()->back();
    }

}
