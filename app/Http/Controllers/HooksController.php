<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Providers\OrderConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HooksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->input('type') === 'payment_intent.succeeded') {
            $payment_intent = $request->input('data')['object'];
            $order = Order::firstWhere('payment_intent_id', $payment_intent['id']);
            $order->payment_intent_status = $payment_intent['status'];
            $order->save();
            if ($payment_intent['status'] === 'succeeded') {
                OrderConfirmed::dispatch($order);
            }
        } else {
            Log::debug($request);
        }
    }
}
