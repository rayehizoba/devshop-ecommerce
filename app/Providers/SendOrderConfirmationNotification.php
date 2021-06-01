<?php

namespace App\Providers;

use App\Providers\OrderConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderConfirmed $event
     * @return void
     */
    public function handle(OrderConfirmed $event)
    {
        Mail::to($event->order->email)->send(new \App\Mail\OrderConfirmed($event->order));
    }
}
