<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\LicenseProduct;
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

    public function render()
    {
        return view('livewire.user.pages.product-page');
    }

    public function addToCart(Product $product)
    {
        $item = [
            'name' => $product->name,
            'price' => LicenseProduct
                ::where('product_id', $product->id)
                ->where('license_id', $this->licenseId)
                ->first()->price,
            'attributes' => ['license_id' => $this->licenseId],
            'associatedModel' => $product,
        ];

        if (\Cart::get($product->id)) {
            \Cart::update($product->id, $item);
        } else {
            \Cart::add(array_merge(
                [
                    'id' => $product->id,
                    'quantity' => 1,
                ],
                $item
            ));
        }

        session()->flash('flash.banner', '“' . $product->name . '” has been added to your cart.');

        return redirect()->to('/cart');
    }
}
