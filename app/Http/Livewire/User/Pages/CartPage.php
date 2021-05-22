<?php

namespace App\Http\Livewire\User\Pages;

use Livewire\Component;

class CartPage extends Component
{
    public function removeItem($key)
    {
        \Cart::remove($key);
    }

    public function render()
    {
        return view('livewire.user.pages.cart-page', [
            'items' => \Cart::getContent(),
            'subtotal' => \Cart::getSubTotal(),
            'total' => \Cart::getTotal(),
        ])->layout('layouts.guest');
    }
}
