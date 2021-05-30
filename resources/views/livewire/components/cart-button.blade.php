<div>
    @if($cartItems->count() > 0)
        <a href="{{ route('cart.page') }}" class="text-blue-500 font-semibold">
            Cart ({{ $cartItems->count() }})
        </a>
    @endif
</div>
