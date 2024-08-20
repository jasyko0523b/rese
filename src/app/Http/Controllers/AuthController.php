<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use DateTime;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('global_admin')) {
            return redirect('/admin/dashboard');
        } elseif ($user->hasRole('shop_admin')) {
            return redirect('/owner/dashboard');
        } else {
            return redirect('/mypage');
        }
    }

    public function myPage(Request $request)
    {
        $auth = $request->user();

        $reservations = Reservation::where('user_id', $auth->id)->get();
        $reserveList = [];
        foreach ($reservations as $reserve) {
            array_push($reserveList, [
                'id' => $reserve->id,
                'shop_name' => Shop::where('id', $reserve->shop_id)->first()->name,
                'date' => date('Y-m-d', strtotime($reserve->date)),
                'time' => date('H:i', strtotime($reserve->date)),
                'number' => $reserve->number,
            ]);
        }

        $favorite = Shop::whereIn('id', $auth->favorite)->get();
        return view('my_page', compact('auth', 'favorite', 'reserveList'));
    }



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

    public function reserve(ReservationRequest $request)
    {
        $reservation = [
            'shop_id' => $request->shop_id,
            'user_id' => $request->user_id,
            'date' => date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time . ':00')),
            'number' => $request->number
        ];
        Reservation::create($reservation);
        return view('done');
    }

    public function update(Request $request)
    {
        $reservation = Reservation::find($request->id);
        $reservation->update(
            [
                'date' =>
                date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time . ':00')),
                'number' => $request->number,
            ]
        );
        return redirect('mypage');
    }

    public function qr_index(Request $request)
    {
        $url = $request->input('url');

        $path = null;
        if (isset($url)) {
            $path = 'qrcode.svg';
            $qrCode = QrCode::generate($url);
            Storage::put($path, $qrCode);
        }

        $data = [
            'url' => $url,
            'path' => $path,
        ];
        return view('qr_reservation', $data);
    }

    public function download(Request $request)
    {
        $path = $request->input('path');
        $download = $request->boolean('download', false);

        if ($download) {
            return response()->download(Storage::path($path));
        };
        return response()->file(Storage::path($path));
    }

}
