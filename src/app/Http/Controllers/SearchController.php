<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();

        if (empty($request->all())) {
            $shops = Shop::all();
        } else {
            $area = $request->area ?? '';
            $genre = $request->genre ?? '';
            $text = $request->text ?? '';

            $shops = Shop::when($area, function ($query, $area) {
                return $query->where('area_id', $area);
            })->when($genre, function ($query, $genre) {
                return $query->where('genre_id', $genre);
            })->when($text, function ($query, $text) {
                return $query->where('name', 'LIKE', '%' . $text . '%');
            })->get();

            if ($shops->isEmpty()) {
                $shops = Shop::all();
                return view('shop_all', compact('shops', 'areas', 'genres'))->with('message', '条件に合う店舗が見つかりませんでした');
            }
        }

        return view('shop_all', compact('shops', 'areas', 'genres'));
    }

    public function admin()
    {
        $shops = Shop::all();
        $addresses = [];
        foreach ($shops as $shop) {
            array_push($addresses, [
                'id' => $shop->id,
                'name' => $shop->name,
                'email' => $shop->owner->email ?? '',
            ]);
        }
        return view('admin.dashboard', compact('addresses'));
    }
}
