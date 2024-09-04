<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{

    // create Review
    public function review(Request $request)
    {
        $review = [
            'shop_id' => $request->shop_id,
            'user_id' => $request->user_id,
            'rank' => $request->rank,
            'comment' => $request->comment,
        ];
        Review::create($review);
        return redirect()->back();
    }

}
