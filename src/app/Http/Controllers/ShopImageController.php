<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopImageRequest;
use Illuminate\Support\Facades\Storage;

class ShopImageController extends Controller
{
    public function index(){
        $path_list = Storage::allFiles('shop_image');
        $image_list = [];
        foreach ($path_list as $index => $path) {
            $image_list[$index] = Storage::url($path);
        }
        return view('admin.shop_image_list', compact('image_list', 'path_list'));
    }

    public function upload(ShopImageRequest $request){
        foreach($request->image_file as $image){
            $image->store('shop_image');
        }
        return redirect('/admin/shop_image');
    }
}
