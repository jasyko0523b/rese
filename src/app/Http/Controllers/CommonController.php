<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;


class CommonController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        $areas = Shop::groupBy('area')->get(['area']);
        $genres = Shop::groupBy('genre')->get(['genre']);
        return view('shop_all', compact('shops', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        if (empty($request->all())) {
            $shops = Shop::all();
        } else {
            $area = $request->area;
            $genre = $request->genre;
            $name = $request->name;
            $shops = Shop::when($area, function ($query, $area) {
                return $query->where('area', $area);
            })->when($genre, function ($query, $genre) {
                return $query->where('genre', $genre);
            })->when($name, function ($query, $name) {
                return $query->where('name', 'LIKE', '%' . $name . '%');
            })->get();
        }

        $areas = Shop::groupBy('area')->get(['area']);
        $genres = Shop::groupBy('genre')->get(['genre']);

        return view('shop_all', compact('shops', 'areas', 'genres'));
    }


    public function detail($shop_id)
    {
        $shop = Shop::where('id', $shop_id)->first();
        $reviews = Review::where('shop_id', $shop_id)->get()->reverse();
        $length = 0;
        $sum = 0;
        $ave = 0;
        foreach ($reviews as $review) {
            $sum = $sum + $review->rank;
            $length++;
        }
        if ($length > 0) {
            $ave = $sum / $length;
        }
        return view('shop_detail', compact('shop', 'reviews', 'ave'));
    }

    public function reservation_info($reservation_id)
    {
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
