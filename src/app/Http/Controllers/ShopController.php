<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopRegisterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\User;


class ShopController extends Controller
{
    public function detail($shop_id)
    {
        $shop = Shop::find($shop_id);
        if (Auth::check()) {
            $my_review = Auth::user()->getReviewOfShop($shop->id);
        } else {
            $my_review = null;
        }
        return view('shop_detail', compact('shop', 'my_review'));
    }

    public function owner_detail(Request $request)
    {
        $user = $request->user();
        $areas = Area::all();
        $genres = Genre::all();
        $shop = $user->shop;
        return view('owner.shop_detail', compact('shop', 'areas', 'genres'));
    }

    public function register()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view('admin.shop_register', compact('areas', 'genres'));
    }

    public function create(ShopRegisterRequest $request)
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
            'name' => $request->shop_name,
            'area_id' => $request->area,
            'genre_id' => $request->genre,
        ];
        Shop::create($shop);
        return redirect('admin/shop_register')->with('message', '作成されました');
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

        $path = $request->file('shop_img')->store('shop_image');

        $new_shop = [
            'image_url' => Storage::url($path) ?? $shop->image_url,
        ];

        $shop->update($new_shop);
        return redirect('owner/shop_detail');
    }
}
