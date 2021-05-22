<div>
    <div>
        @if (session()->has('message'))
            <div class="text-center text-white text-sm p-3 bg-green-400">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="container py-10 space-y-10">

        <div class="flex items-center">
            <figure class="text-4xl md:text-5xl leading-tight md:leading-snug">
                🖥️📱
            </figure>
            <div>
                <h1 class="font-bold text-2xl md:text-3xl self-start">
                    devshop
                </h1>
                <ul class="flex items-center text-xs md:text-sm text-gray-500 space-x-1">
                    <li>
                        <a href="/" class="text-green-700 transition hover:text-green-900">
                            Home
                        </a>
                    </li>
                    <li>
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li>
                        Cart
                    </li>
                </ul>
            </div>
        </div>

        <div class="grid gap-10 lg:gap-16 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-5">
                @if(\Cart::isEmpty())
                    <div class="space-y-3">
                        <p class="text-xl text-yellow-900 bg-yellow-50 p-5 inline-block border border-yellow-100">
                            🛒
                            Your cart is currently empty
                        </p>
                        <br>
                        <a href="{{ route('shop.page') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            Return to shop
                        </a>
                    </div>
                @else
                    <ul class="divide-y">
                        @foreach($items as $item)
                            <li wire:key="{{ $item->id }}" class="flex items-center space-x-2 lg:space-x-4 py-5">
                                <a href="{{ route('product', ['slug' => $item->attributes->slug]) }}">
                                    <div class="h-16 w-20 bg-gray-100 bg-center bg-cover border rounded"
                                         style="background-image: url({{ $item->attributes->cover_image_path }})"></div>
                                </a>
                                <div class="flex-1 space-y-1">
                                    <p class="font-medium text-sm">
                                        <a href="{{ route('product', ['slug' => $item->attributes->slug]) }}">
                                            {{ $item->name }}
                                        </a>
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        License Type: {{ $item->attributes->license_type }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end space-y-1">
                                    <p class="font-medium text-sm">
                                        ${{ $item->price }}
                                    </p>
                                    <button wire:click="removeItem({{ $item->id }})"
                                            class="focus:outline-none text-xs text-gray-500 transition-gpu hover:text-blue-500 hover:border-blue-500 border-b">
                                        Remove
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex space-x-5">
                        <div class="flex-1">
                            <input type="text" placeholder="Coupon code"
                                   class="p-2 rounded border text-sm focus:outline-none focus:ring w-full">
                        </div>
                        <button type="button" class="btn-outline md:w-40 lg:w-56">
                            Apply
                        </button>
                    </div>
                @endif
            </div>
            <div class="border rounded p-5 space-y-5">
                <ul class="text-sm divide-y space-y-3">
                    <li class="flex justify-between items-center">
                        <p>Subtotal</p>
                        <p>${{ $subtotal }}</p>
                    </li>
                    <li class="flex justify-between items-center pt-3">
                        <p>Total</p>
                        <p>${{ $total }}</p>
                    </li>
                </ul>
                <a href="./checkout.html" class="btn-primary block text-center">
                    Proceed to checkout
                </a>
                <ul class="text-gray-500 text-xs space-y-2">
                    <li class="flex space-x-1">
                        <span>✅</span>
                        <p>
                            100% Satisfaction Guarantee
                        </p>
                    </li>
                    <li class="flex space-x-1">
                        <span>✅</span>
                        <p>
                            6 months technical support
                        </p>
                    </li>
                    <li class="flex space-x-1">
                        <span>✅</span>
                        <p>
                            30-day money-back guarantee
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
