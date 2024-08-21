<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use Storage;

class CommonController extends Controller
{
    public function index(Request $request/*, $area = '東京都', $genre = '寿司', $text = '人'*/)
    {
        $areas = Shop::groupBy('area')->get(['area']);
        $genres = Shop::groupBy('genre')->get(['genre']);

        if (empty($request->all())) {
            $shops = Shop::all();
        } else {
            $area = $request->area ?? '';
            $genre = $request->genre ?? '';
            $text = $request->text ?? '';

            $shops = Shop::when($area, function ($query, $area) {
                return $query->where('area', $area);
            })->when($genre, function ($query, $genre) {
                return $query->where('genre', $genre);
            })->when($text, function ($query, $text) {
                return $query->where('name', 'LIKE', '%' . $text . '%');
            })->get();

            if($shops->isEmpty()){
                $shops = Shop::all();
                return view('shop_all', compact('shops', 'areas', 'genres'))->with('message', '条件に合う店舗が見つかりませんでした');
            }
        }

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
