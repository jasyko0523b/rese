<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
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
}
