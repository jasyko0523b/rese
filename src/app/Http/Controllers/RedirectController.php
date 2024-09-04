<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
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


}
