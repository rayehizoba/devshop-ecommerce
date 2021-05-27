<?php

namespace App\Http\Livewire\User\Pages;

use App\Models\Subscriber;
use Livewire\Component;

class CheckoutPage extends Component
{

    public $name;
    public $email;
    public $subscribe = true;
    public $create_account = false;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
    ];

    public function mount()
    {
        if (\Cart::isEmpty()) {
            return redirect()->to('/cart');
        }
    }

    public function render()
    {
        return view('livewire.user.pages.checkout-page', [
            'items' => \Cart::getContent(),
            'subtotal' => \Cart::getSubTotal(),
            'total' => \Cart::getTotal(),
            'paymentIntent' => $this->_createPaymentIntent(),
        ])->layout('layouts.blank');
    }

    public function validateForm()
    {
        return $this->validate();
    }

    protected $listeners = ['orderComplete' => 'orderComplete'];

    public function orderComplete($payment_intent_id)
    {
//        Order::create([
//            'name' => $this->name,
//            'email' => $this->email,
//            'payment_intent_id' => $payment_intent_id,
//            'items' => \Cart::getContent(),
//            'total' => \Cart::getTotal(),
//        ]);
//        dispatch order complete email using a queue that reacts to order.create events
//        this email will list the licensed products and show a download link for each licensed product

        \Cart::clear();

        $subscriber = Subscriber::firstOrNew(['email' => $this->email]);
        $subscriber->save();

        return redirect()->to('/order-received');
    }

    private function _convertDollarsToCents($dollars)
    {
        return $dollars * 100;
    }

    private function _createPaymentIntent()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        return \Stripe\PaymentIntent::create([
            'amount' => $this->_convertDollarsToCents(\Cart::getTotal()),
            'currency' => 'usd',
        ]);
    }
}
