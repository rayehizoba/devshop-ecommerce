<?php

namespace App\Http\Livewire\User\Pages;

use Livewire\Component;

class CheckoutPage extends Component
{
    public function mount()
    {
        if (\Cart::isEmpty()) {
            return redirect()->to('/cart');
        }
    }

    public function render()
    {
        return view('livewire.user.pages.checkout-page', [
            'items' => \Cart::getContent(),
            'subtotal' => \Cart::getSubTotal(),
            'total' => \Cart::getTotal(),
        ])->layout('layouts.blank');
    }
}
