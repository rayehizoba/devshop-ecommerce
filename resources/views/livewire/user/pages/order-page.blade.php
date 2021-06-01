<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    <div class="space-y-5">
        <h1 class="text-2xl md:text-3xl tracking-tight">
            Thank you. Your order has been received.
        </h1>
        <ul class="space-y-3">
            <li class="flex uppercase space-x-3 items-center">
                <p class="text-gray-500 font-medium">
                    <i class="mdi mdi-pound"></i>
                    Order No.:
                </p>
                <p>
                    {{ $order->number }}
                </p>
            </li>
            <li class="flex uppercase space-x-3 items-center">
                <p class="text-gray-500 font-medium">
                    <i class="mdi mdi-calendar"></i>
                    Order Date:
                </p>
                <p>
                    @dateforhumans($order->created_at)
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
                <p class="text-sm text-gray-500">
                    Your downloads will never expire
                </p>
            </div>

            <ol>
                @foreach($order->lines as $line)
                    <li class="space-y-1 p-3 text-gray-500 flex justify-between items-center @if($loop->even) bg-gray-100 @endif">
                        <a class="text-blue-500 hover:underline mr-3"
                           href="{{ route('product', ['slug' => $line->product->slug]) }}">
                            {{ $line->product->name }}
                        </a>
                        <a href="{{ $line->package_path }}"
                           class="uppercase text-sm font-medium hover:text-blue-500 flex space-x-1 items-center">
                            <i class="mdi mdi-folder-zip text-base"></i>
                            <span>Download</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
        <div class="w-full lg:w-5/12 border border-gray-300 rounded-lg shadow-lg p-5 space-y-5">
            <p class="font-medium text-2xl">
                Order Details
            </p>
            <ul class="text-sm divide-y space-y-3">
                @foreach($order->lines as $line)
                    <li class="flex justify-between items-center space-x-10 pt-3">
                        <div class="flex-1 space-y-1">
                            <div class="text-sm flex space-x-1">
                                <p>{{ $line->product->name }}</p>
                                <i class="mdi mdi-close"></i>
                                <strong>{{ $line->quantity }}</strong>
                            </div>
                            <p class="text-gray-500 text-xs">
                                License Type: {{ $line->license->name }}
                            </p>
                        </div>
                        <p>${{ $line->price }}</p>
                    </li>
                @endforeach
                <li class="flex justify-between items-center pt-3">
                    <p>Subtotal</p>
                    <p>${{ $order->total }}</p>
                </li>
                <li class="flex justify-between items-center pt-3">
                    <p>Total</p>
                    <p>${{ $order->total }}</p>
                </li>
            </ul>
        </div>
    </div>
</div>
