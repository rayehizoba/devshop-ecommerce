<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class NavigationMenu extends Component
{
    public $cart;

    protected $listeners = ['cart:refresh' => 'setCart'];

    public function mount()
    {
        $this->setCart();
    }

    public function setCart()
    {
        $this->cart = \Cart::getContent()->count();
    }

    public function render()
    {
        return view('livewire.components.navigation-menu');
    }
}
