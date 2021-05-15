<?php

namespace App\Http\Livewire\Pages;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
//        TODO: correct the following queries
        return view('livewire.pages.index', [
            'latest_products' => Product::take(4)->get(),
            'popular_products' => Product::all()
        ])->layout('layouts.guest');
    }
}
