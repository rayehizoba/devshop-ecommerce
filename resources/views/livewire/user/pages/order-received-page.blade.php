<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">
    <div class="space-y-5">
        <h1 class="text-2xl tracking-tight">
            Thank you. Your order has been received.
        </h1>

        <ul class="flex border-b border-t border-gray-300">
            <li class="py-2 px-4 border-l border-gray-300">
                <p class="uppercase text-gray-500 text-xs">
                    Order Number:
                </p>
                <p class="text-sm font-medium">
                    {{ $order->id }}
                </p>
            </li>
            <li class="py-2 px-4 border-l border-gray-300">
                <p class="uppercase text-gray-500 text-xs">
                    Date:
                </p>
                <p class="text-sm font-medium">
                    @dateforhumans($order->created_at)
                </p>
            </li>
            <li class="py-2 px-4 border-l border-gray-300">
                <p class="uppercase text-gray-500 text-xs">
                    Total:
                </p>
                <p class="text-sm font-medium">
                    ${{ $total }}
                </p>
            </li>
        </ul>
    </div>

    <div class="flex flex-col space-y-10 md:space-y-0 md:flex-row md:space-x-10 lg:space-x-16 md:items-start">
        <div class="w-full lg:w-7/12 space-y-5">
            <div>
                <p class="font-medium text-2xl">
                    Downloads
                </p>
                <p class="text-xs text-gray-500">
                    Your downloads will never expire
                </p>
            </div>

            <ol class="list-decimal pl-5 text-sm">
                @foreach($items as $item)
                    <li>
                        <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-5 py-3">
                            <a class="text-blue-500 hover:underline"
                               href="{{ route('product', ['slug' => $item->attributes->product_slug]) }}">
                                {{ $item->name }}
                            </a>
                            <a href="{{ $item->attributes->product_download_path }}"
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition space-x-1">
                                <i class="mdi mdi-download"></i>
                                <span>Download</span>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
        <div class="w-full lg:w-5/12 border border-gray-300 rounded-lg shadow-lg p-5 space-y-5">
            <p class="font-medium text-2xl">
                Order Details
            </p>
            <ul class="text-sm divide-y space-y-3">
                @foreach($items as $item)
                    <li class="flex justify-between items-center space-x-10 pt-3">
                        <div class="flex-1 space-y-1">
                            <div class="text-sm flex space-x-1">
                                <p>{{ $item->name }}</p>
                                <i class="mdi mdi-close"></i>
                                <strong>{{ $item->quantity }}</strong>
                            </div>
                            <p class="text-gray-500 text-xs">
                                License Type: {{ $item->attributes->license_type }}
                            </p>
                        </div>
                        <p>${{ $item->price }}</p>
                    </li>
                @endforeach
                <li class="flex justify-between items-center pt-3">
                    <p>Subtotal</p>
                    <p>${{ $subtotal }}</p>
                </li>
                <li class="flex justify-between items-center pt-3">
                    <p>Total</p>
                    <p>${{ $total }}</p>
                </li>
            </ul>
        </div>
    </div>
</div>
