<?php

namespace App\Http\Livewire\Pages;

use App\Models\Product;
use Livewire\Component;

class ProductPage extends Component
{
    public $product;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->first();
    }

    public function render()
    {
        return view('livewire.pages.product-page')->layout('layouts.guest');
    }
}
