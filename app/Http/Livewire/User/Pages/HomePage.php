<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Product;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.user.pages.home-page', [
            'latest_products' => Product::orderBy('updated_at', 'desc')->take(3)->get(),
            // TODO: correct the query for popular_products
            'popular_products' => Product::all()
        ])->layout('layouts.guest');
    }
}
