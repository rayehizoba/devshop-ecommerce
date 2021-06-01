<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Order;
use Livewire\Component;

class OrderPage extends Component
{
    public $order;

    public function mount($number)
    {
        $this->order = Order::where('number', $number)->firstOrFail();
    }

    public function render()
    {
//        $cart = \Cart::session('order'.$this->order->id);
//        $cart->clear();
//
//        foreach ($this->order->lines as $line) {
//            $license = $line->product->licenses->first(function ($license, $key) use ($line) {
//                return $license->id == $line->license_id;
//            });
//            $cart->add([
//                'id' => $line->id,
//                'name' => $line->product->name,
//                'price' => $line->price,
//                'quantity' => 1,
//                'attributes' => [
//                    'product_slug' => $line->product->slug,
//                    'product_download_path' => $license->pivot->download_path,
//                    'license_type' => $line->license->name,
//                ],
//            ]);
//        }

        return view('livewire.user.pages.order-page', [
            'items' => [],
//            'subtotal' => 100,
//            'total' => 100,
        ]);
    }
}
