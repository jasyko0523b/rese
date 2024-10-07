<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\Shop;

class ReviewController extends Controller
{
    public function index($shop_id)
    {
        if (Auth::check()) {
            $my_review = Auth::user()->getReviewOfShop($shop_id);
        } else {
            $my_review = null;
        }
        $shop = Shop::find($shop_id);
        return view('shop_review', compact('shop', 'my_review'));
    }

    public function review($shop_id, ReviewRequest $request)
    {
        $my_review = Auth::user()->getReviewOfShop($shop_id);

        //update
        if ($my_review != null) {
            $this->update($shop_id, $my_review, $request);
        } else {
            $this->create($shop_id, $request);
        }
        return redirect('/detail/' . $shop_id);
    }

    public function delete($shop_id, Request $request)
    {
        Review::find($request->review_id)->deleteWithImage();
        return redirect('/detail/' . $shop_id)->with('message', '口コミを削除しました');
    }

    private function create($shop_id, $request)
    {
        if ($request->file('review_img') != '' && !$request->image_delete_check) {
            $path = $request->file('review_img')->store('review_image/' . $shop_id);
            $review = [
                'shop_id' => $request->shop_id,
                'user_id' => $request->user_id,
                'rank' => $request->rank,
                'comment' => $request->comment,
                'image_url' => Storage::url($path),
            ];
        } else {
            $review = [
                'shop_id' => $request->shop_id,
                'user_id' => $request->user_id,
                'rank' => $request->rank,
                'comment' => $request->comment,
            ];
        }
        Review::create($review);
    }

    private function update($shop_id, $my_review, $request)
    {
        if ($request->file('review_img') != '') {
            // ファイルがあった場合
            $my_review->deleteImage();
            $path = $request->file('review_img')->store('review_image/' . $shop_id);
            $new_review = [
                'rank' => $request->rank,
                'comment' => $request->comment,
                'image_url' => Storage::url($path),
            ];
        } else {
            if ($request->image_delete_check) {
                // 元の画像を破棄する場合
                $my_review->deleteImage();
                $new_review = [
                    'rank' => $request->rank,
                    'comment' => $request->comment,
                    'image_url' => null,
                ];
            } else {
                // 元の画像を保持する場合
                $new_review = [
                    'rank' => $request->rank,
                    'comment' => $request->comment,
                ];
            }
        }
        $my_review->update($new_review);
    }
}
