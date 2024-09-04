<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Review;
use App\Models\User;


class ShopController extends Controller
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
                return $query->where('area_id', 2);
            })->get();

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


    public function admin()
    {
        $shops = Shop::all();
        $addresses = [];
        foreach ($shops as $shop) {
            array_push($addresses, [
                'id' => $shop->id,
                'name' => $shop->name,
                'email' => User::where('id', $shop->owner_id)->first()->email ?? '',
            ]);
        }
        return view('admin.dashboard', compact('addresses'));
    }


    public function register()
    {
        return view('admin.shop_register');
    }


    public function create(Request $request)
    {
        $register = [
            'name' => $request->shop_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];
        $owner = User::create($register);
        $owner->assignRole('shop_admin');
        $owner->sendEmailVerificationNotification();

        $shop = [
            'owner_id' => $owner->id,
            'name' => '新規店舗',
        ];
        Shop::create($shop);
        return redirect('admin/dashboard');
    }

    public function owner_detail(Request $request)
    {
        $user = $request->user();
        $areas = Area::all();
        $genres = Genre::all();
        $shop = Shop::where('owner_id', $user->id)->first();
        return view('owner.shop_detail', compact('shop', 'areas', 'genres'));
    }


    public function update_text(Request $request)
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


    public function update_image(Request $request)
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
