<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest;
use App\Models\User;
use App\Models\Shop;

class CsvController extends Controller
{
    public function index() {
        return view('admin.shop_csv');
    }

    public function import(CsvRequest $request){
        foreach($request->csv_array as $record){
            $register = [
                'name' => $record["name"],
                'email' => $record["email"],
                'password' => bcrypt($record["password"]),
            ];
            $owner = User::create($register);
            $owner->assignRole('shop_admin');
            $owner->sendEmailVerificationNotification();

            $shop = [
                'owner_id' => $owner->id,
                'name' => $record["name"],
                'area_id' => $record["area_id"],
                'genre_id' => $record["genre_id"],
                'sentence' => $record["sentence"],
                'image_url' => $record["image_url"],
            ];
            Shop::create($shop);
        }
        $number = count($request->csv_array);
        return redirect('admin/shop_csv')->with('message', "{$number}件、インポートされました");
    }
}
