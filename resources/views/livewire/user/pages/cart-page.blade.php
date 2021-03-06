<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <div class="flex items-center">
        <figure class="text-4xl md:text-5xl leading-tight md:leading-snug">
            🖥️📱
        </figure>
        <div>
            <h1 class="font-bold text-2xl self-start">
                devshop
            </h1>
            <ul class="flex items-center text-xs md:text-sm text-gray-500 space-x-1">
                <li>
                    <a href="{{ route('home.page') }}" class="text-blue-500 transition hover:text-gray-500">
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

    <div class="flex flex-col space-y-10 md:space-y-0 md:flex-row md:space-x-10 lg:space-x-16 md:items-start">
        <div class="w-full lg:w-7/12 space-y-5">
            @if(\Cart::isEmpty())
                <div class="space-y-3 text-center flex flex-col items-center justify-center py-12">
                    <p class="text-lg md:text-2xl">
                        🛒 Your cart is currently empty
                    </p>
                    <a href="{{ route('shop.page') }}"
                       class="btn-secondary w-full lg:w-auto justify-center">
                        Return to shop
                    </a>
                </div>
            @else
                <ul class="divide-y">
                    @foreach($items as $item)
                        <li wire:key="{{ $item['id'] }}" class="flex items-center space-x-2 lg:space-x-4 py-5">
                            <a href="{{ route('product', ['slug' => $item['slug']]) }}">
                                <div class="h-16 w-20 bg-gray-100 bg-center bg-cover border rounded"
                                     style="background-image: url({{ Storage::url($item['cover_image_path']) }})"></div>
                            </a>
                            <div class="flex-1 space-y-1">
                                <p class="font-medium text-sm">
                                    <a href="{{ route('product', ['slug' => $item['slug']]) }}">
                                        {{ $item['name'] }}
                                    </a>
                                </p>
                                <p class="text-gray-500 text-xs">
                                    License Type: {{ $item['license_name'] }}
                                </p>
                            </div>
                            <div class="flex flex-col items-end space-y-1">
                                <p class="font-medium text-sm">
                                    ${{ $item['price'] }}
                                </p>
                                <button wire:click="removeItem({{ $item['id'] }})"
                                        class="focus:outline-none text-xs text-gray-500 transition-gpu hover:text-blue-500 hover:border-blue-500 border-b">
                                    Remove
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="flex space-x-2">
                    <div class="flex-1">
                        <x-jet-input type="text" placeholder="Coupon code" class="w-full"/>
                    </div>
                    <x-jet-secondary-button type="button" class="px-10">
                        Apply
                    </x-jet-secondary-button>
                </div>
            @endif
        </div>
        <div class="w-full lg:w-5/12 border border-gray-300 rounded-lg p-5 space-y-5 shadow-lg border border-gray-300">
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
            <a href="{{ route('checkout.page') }}"
               class="inline-flex w-full justify-center items-center px-4 py-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Proceed to checkout
            </a>
            <ul class="text-gray-500 text-xs space-y-2 lg:pr-10 xl:pr-20">
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
