<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Licences') }}
                </h2>
                <x-jet-button wire:click="create">
                    {{ __('New License') }}
                </x-jet-button>
            </div>
        </div>
    </header>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 space-y-3">
                <x-table>
                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('order')"
                                         :direction="$sortField === 'order' ? $sortDirection : null">
                            Order
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                                         :direction="$sortField === 'name' ? $sortDirection : null">
                            License
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('summary')"
                                         :direction="$sortField === 'summary' ? $sortDirection : null">
                            Summary
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('updated_at')"
                                         :direction="$sortField === 'updated_at' ? $sortDirection : null">
                            Updated
                        </x-table.heading>
                        <x-table.heading></x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @forelse($licenses as $license)
                            <x-table.row wire:key="{{ $license->id }}" wire:loading.class.delay="opacity-50" class="transition">
                                <x-table.cell>
                                    {{ $license->order }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $license->name }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $license->summary }}
                                </x-table.cell>
                                <x-table.cell>
                                    @dateforhumans($license->updated_at)
                                </x-table.cell>
                                <x-table.cell class="flex justify-end space-x-2">
                                    <button wire:click="edit({{ $license->id }})" type="button"
                                            class="text-gray-500 capitalize text-xs transition bg-gray-200 rounded-md p-1 px-5 hover:bg-gray-300 font-bold focus:outline-none focus:ring focus:ring-gray-100">
                                        edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $license->id }})" type="button"
                                            class="text-gray-500 capitalize text-xs transition bg-gray-200 rounded-md p-1 px-5 hover:bg-gray-300 font-bold focus:outline-none focus:ring focus:ring-gray-100">
                                        delete
                                    </button>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="4">
                                    <div class="text-xl py-8 text-gray-400 text-center">
                                        No licenses found...
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-table>

                <div class="flex items-center justify-between space-x-5">
                    <select class="text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="pageSize">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    <div class="flex-1">
                        {{ $licenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
