<?php

namespace App\Http\Controllers;

use App\Mail\AnnounceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Shop;
use App\Models\User;

class AdminController extends Controller
{
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

    public function email_writing()
    {
        return view('admin.email_writing');
    }


    public function send_all(Request $request)
    {
        $users = User::all();
        foreach($users as $user) {
            Mail::to($user)->send(new AnnounceMail());
        }
        return redirect('admin/email')->with('message', 'ユーザー全員に送信されました');
    }
}
