<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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


    public function owner_detail(Request $request)
    {
        $user = $request->user();
        $shop = Shop::where('owner_id', $user->id)->first();
        return view('owner.shop_detail', compact('shop'));
    }




    public function text_update(Request $request)
    {
        $user = $request->user();
        $shop = Shop::where('owner_id', $user->id)->first();

        $new_shop = [
            'name' => $request->name ?? $shop->name,
            'area' => $request->area ?? $shop->area,
            'genre' => $request->genre ?? $shop->genre,
            'sentence' => $request->sentence ?? $shop->sentence,
        ];

        $shop->update($new_shop);
        return redirect('owner/shop_detail');
    }

    public function image_update(Request $request)
    {
        $user = $request->user();
        $shop = Shop::where('owner_id', $user->id)->first();

        $path = $request->file('shop_img')->store('shop_image', 'public');

        $new_shop = [
            'image_url' => Storage::url($path) ?? $shop->image_url,
        ];

        $shop->update($new_shop);
        return redirect('owner/shop_detail');
    }
}
