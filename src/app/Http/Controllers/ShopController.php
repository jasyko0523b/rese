<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
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
        return view('shop_detail', ['shop' => $shop]);
    }

}
