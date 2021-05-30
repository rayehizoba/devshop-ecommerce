<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class CartButton extends Component
{
    public $cartItems;

    protected $listeners = ['cart:refresh' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cartItems = \Cart::getContent();
    }

    public function render()
    {
        return view('livewire.components.cart-button');
    }
}
