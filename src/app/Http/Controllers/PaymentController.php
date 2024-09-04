<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class PaymentController extends Controller
{

    public function amount(){
        return view('payment.amount');
    }

    public function create(Request $request)
    {
        $amount = $request->amount;
        return view('payment.create', compact('amount'));
    }


    public function store(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => $request->amount,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！(' . $e->getMessage() . ')');
        }
    return view('payment.done')->with('message', '決済が完了しました');
    }
}
