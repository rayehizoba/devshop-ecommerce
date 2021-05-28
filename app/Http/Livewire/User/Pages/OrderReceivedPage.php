<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Order;
use Livewire\Component;

class OrderReceivedPage extends Component
{
    public $order;

    public function mount(Order $order)
    {
        $this->order = $order->load('lines');
    }

    public function render()
    {
        $cart = \Cart::session('order-received'.$this->order->id);
        $cart->clear();

        foreach ($this->order->lines as $line) {
            $license = $line->product->licenses->first(function ($license, $key) use ($line) {
                return $license->id == $line->license_id;
            });
            $cart->add([
                'id' => $line->id,
                'name' => $line->product->name,
                'price' => $line->price,
                'quantity' => 1,
                'attributes' => [
                    'product_slug' => $line->product->slug,
                    'product_download_path' => $license->pivot->download_path,
                    'license_type' => $line->license->name,
                ],
            ]);
        }

        return view('livewire.user.pages.order-received-page', [
            'items' => $cart->getContent(),
            'subtotal' => $cart->getSubTotal(),
            'total' => $cart->getTotal(),
        ])->layout('layouts.guest');
    }
}
