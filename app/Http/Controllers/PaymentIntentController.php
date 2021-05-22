<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentIntentController extends Controller
{
    public function __invoke(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $cart = \Cart::session('payment-intent');
        $cart->clear();

        foreach ($request->all() as $each) {
            $cart->add($each);
        }

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $this->_convertDollarsToCents($cart->getTotal()),
            'currency' => 'usd',
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        Log::debug($output);
        return $output;
    }

    private function _convertDollarsToCents($dollars)
    {
        return $dollars * 100;
    }
}
