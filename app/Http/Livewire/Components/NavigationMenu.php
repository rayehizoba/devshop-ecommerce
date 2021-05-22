<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class NavigationMenu extends Component
{
    public $cart;

    public function mount()
    {
        $this->cart = \Cart::getContent()->count();
    }

    public function render()
    {
        return view('livewire.components.navigation-menu');
    }
}
