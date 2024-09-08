<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{

    public function please_verify()
    {
        if (!is_null(Auth::user()->email_verified_at)) {
            return redirect('redirects');
        }
        return view('auth.verify-email');
    }


    public function verified(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/mypage');
    }

    public function send_request(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', __('message.retransmission'));
    }
}
