<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Product;
use Livewire\Component;

class ProductPage extends Component
{
    public $product;

    public $licenseId;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->first();
        $this->licenseId = $this->product->cheapestLicense()->id;
    }

    public function addToCart(Product $product)
    {
        $license = $this->product->licenses->first(function ($license, $key) {
            return $license->id == $this->licenseId;
        });

        $key = $license->pivot->product_id . $license->pivot->license_id;
//        return \Cart::clear();
//        dd($key);

        \Cart::add([
            'id' => $key,
            'name' => $product->name,
            'price' => $license->pivot->price,
            'quantity' => 1,
            'attributes' => [
                'cover_image_path' => $product->cover_image_path,
                'license_type' => $license->name,
                'slug' => $product->slug,
            ]
//            'associatedModel' => $product,
        ]);

        session()->flash('message', '“' . $product->name . '” has been added to your cart.');

        return redirect()->to('/cart');
    }

    public function render()
    {
        return view('livewire.user.pages.product-page')->layout('layouts.guest');
    }
}
