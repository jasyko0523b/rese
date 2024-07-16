<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Review;
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
        $reviews = Review::where('shop_id', $shop_id)->get()->reverse();
        return view('shop_detail', compact('shop', 'reviews'));
    }


    public function owner_detail(Request $request){
        $user = $request->user();
        $shop = Shop::where('owner_id', $user->id)->first();
        return view('owner.shop_detail', compact('shop'));
    }

    public function update(Request $request){
        $user = $request->user();
        $shop = Shop::where('owner_id', $user->id)->first();
        $shop->update($request->all());
        return redirect('owner/shop_detail');
    }
}
