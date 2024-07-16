<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;

class AdminController extends Controller
{
    public function admin()
    {
        $shops = Shop::all();
        $addresses=[];
        foreach($shops as $shop){
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
            'password' => bcrypt('resePass001'),
        ];
        $owner = User::create($register);
        $owner->assignRole('owner');
        $shop = [
            'owner_id' => $owner->id,
            'name' => '新規店舗',
        ];
        Shop::create($shop);
        return redirect('admin/dashboard');
    }

}
