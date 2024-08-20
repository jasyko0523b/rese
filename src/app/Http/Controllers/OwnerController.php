<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $owner = $request->user();
        $shop_id = Shop::where('owner_id', $owner->id)->first()->id;
        $reservations = Reservation::where('shop_id', $shop_id)->oldest('date')->get();
        $today = strtotime(now()->format('Y-m-d'));
        $today_records = [];
        $future_records = [];
        $past_records = [];
        foreach ($reservations as $reserve) {
            $record = [
                'date' => date('Y/m/d', strtotime($reserve->date)),
                'time' => date('H:i', strtotime($reserve->date)),
                'number' => $reserve->number,
                'user_name' => User::find($reserve->user_id)->name,
            ];
            $date = strtotime($record['date']);
            if ($today > $date) {
                array_push($past_records, $record);
            } elseif ($today == $date) {
                array_push($today_records, $record);
            } else {
                array_push($future_records, $record);
            }
        }
        array_multisort($past_records, SORT_DESC);
        return view('owner.dashboard', compact('past_records', 'today_records', 'future_records'));
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
