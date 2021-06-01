<?php

namespace App\Http\Livewire\User\Pages;

use App\Http\Traits\HasCart;
use Livewire\Component;

class CartPage extends Component
{
    use HasCart;

    public function removeItem($key)
    {
        \Cart::remove($key);
        $this->emit('cart:refresh');
    }

    public function render()
    {
        return view('livewire.user.pages.cart-page', [
            'items' => $this->_getCartContent(),
            'subtotal' => \Cart::getSubTotal(),
            'total' => \Cart::getTotal(),
        ]);
    }
}
