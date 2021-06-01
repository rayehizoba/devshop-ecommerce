<div x-data class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
        </div>
    </header>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 space-y-3">
                <div class="flex">
                    <x-jet-input class="block w-full md:w-auto" type="text" placeholder="Search..."
                                 wire:model="search"/>
                </div>

                <x-table style="min-width: 1000px">
                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('number')"
                                         :direction="$sortField === 'number' ? $sortDirection : null">
                            #
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                                         :direction="$sortField === 'name' ? $sortDirection : null">
                            Name
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('email')"
                                         :direction="$sortField === 'email' ? $sortDirection : null">
                            Email
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('updated_at')"
                                         :direction="$sortField === 'updated_at' ? $sortDirection : null">
                            Updated
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('payment_intent_status')"
                                         :direction="$sortField === 'payment_intent_status' ? $sortDirection : null">
                            Status
                        </x-table.heading>
                        <x-table.heading>
                            Total
                        </x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @forelse($orders as $order)
                            <x-table.row wire:key="{{ $order->id }}" wire:loading.class.delay="animate-pulse">
                                <x-table.cell>
                                    <a href="{{ route('order.page', ['number' => $order->number]) }}"
                                       class="hover:underline" target="_blank">
                                        {{ $order->number }}
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $order->name }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $order->email }}
                                </x-table.cell>
                                <x-table.cell>
                                    @dateforhumans($order->updated_at)
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $order->payment_intent_status }}
                                </x-table.cell>
                                <x-table.cell>
                                    @priceforhumans($order->total)
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="5">
                                    <div class="text-xl py-8 text-gray-400 text-center">
                                        No orders found...
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-table>

                <div class="flex items-center justify-between space-x-5">
                    <x-input.page-size wire:model="pageSize"/>
                    <div class="flex-1">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
