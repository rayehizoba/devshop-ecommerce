<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrdersPage extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order
            ::where('payment_intent_status', 'succeeded')
            ->where('email', Auth::user()->email)
            ->orderBy('number', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.user.pages.orders-page');
    }
}
