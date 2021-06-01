<?php

namespace App\Http\Livewire\User\Pages;

use App\Http\Traits\HasCart;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutPage extends Component
{
    use HasCart;

    public $name;
    public $email;
    public $subscribe = true;

    public $paymentIntent;
    public $items = [];
    public $subtotal = 0;
    public $total = 0;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
    ];

    protected $listeners = [
        'order:success' => 'clearCart'
    ];

    public function mount()
    {
        if (\Cart::isEmpty()) {
            return redirect()->to('/cart');
        }

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $this->paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => \Cart::getTotal() * 100, // convert dollars to cents
            'currency' => 'usd',
        ])->toArray();
        $this->items = $this->_getCartContent();
        $this->subtotal = \Cart::getSubTotal();
        $this->total = \Cart::getTotal();
    }

    public function render()
    {
        return view('livewire.user.pages.checkout-page')->layout('layouts.blank');
    }

    public function validateForm()
    {
        return $this->validate();
    }

    public function placeOrder($payment_intent_id)
    {
        $lastOrder = Order::latest('updated_at')->first();

        $order = Order::firstOrCreate(
            ['payment_intent_id' => $payment_intent_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'number' => str_pad($lastOrder->id + 1, 8, "0", STR_PAD_LEFT),
            ]
        );

        foreach (\Cart::getContent() as $line) {
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $line->id,
                'license_id' => $line->attributes->license_id,
                'quantity' => $line->quantity,
                'price' => $line->price,
            ]);
        }

        if ($this->subscribe) {
            $subscriber = Subscriber::firstOrNew(['email' => $this->email]);
            $subscriber->save();
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        \Stripe\PaymentIntent::update($payment_intent_id, [
            'metadata' => ['order_id' => $order->id]
        ]);
    }

    public function clearCart()
    {
        \Cart::clear();
    }
}
