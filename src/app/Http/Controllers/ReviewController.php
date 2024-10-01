<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    public function review(ReviewRequest $request)
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
