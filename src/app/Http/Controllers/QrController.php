<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reservation;

class QrController extends Controller
{
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


    public function reservation_info($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        return view('info_reservation', compact('reservation'));
    }
}
