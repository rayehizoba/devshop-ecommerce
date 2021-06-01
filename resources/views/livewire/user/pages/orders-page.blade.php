<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <ul class="list-disc list-inside">
        @foreach($orders as $order)
        <li>
            <a href="{{ route('order.page', ['number' => $order->number]) }}">
                #{{ $order->number }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
