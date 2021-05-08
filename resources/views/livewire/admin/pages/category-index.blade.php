<div x-data>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Categories') }}
                </h2>
                <x-jet-button wire:click="create">
                    {{ __('New Category') }}
                </x-jet-button>
            </div>
        </div>
    </header>

    <div>
        @if (session()->has('message'))
            <div class="bg-green-100 text-green-900 py-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{ session('message') }}
                </div>
            </div>
        @endif
    </div>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 space-y-3">
                <div class="flex">
                    <x-jet-input class="block text-sm w-full md:w-auto" type="text" placeholder="Search..."
                                 wire:model="search"/>
                </div>

                <x-table>
                    <x-slot name="head">
                        <x-table.heading sortable wire:click="sortBy('order')"
                                         :direction="$sortField === 'order' ? $sortDirection : null">
                            Order
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('name')"
                                         :direction="$sortField === 'name' ? $sortDirection : null">
                            Category
                        </x-table.heading>
                        <x-table.heading sortable wire:click="sortBy('updated_at')"
                                         :direction="$sortField === 'updated_at' ? $sortDirection : null">
                            Updated
                        </x-table.heading>
                        <x-table.heading></x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @forelse($categories as $category)
                            <x-table.row wire:key="{{ $category->id }}" wire:loading.class.delay="opacity-50" class="transition">
                                <x-table.cell>
                                    {{ $category->order }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $category->name }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $category->updated_at_for_humans }}
                                </x-table.cell>
                                <x-table.cell class="flex justify-end space-x-2">
                                    <button wire:click="edit({{ $category->id }})" type="button"
                                            class="text-gray-500 capitalize text-xs transition bg-gray-200 rounded-md p-1 px-5 hover:bg-gray-300 font-bold focus:outline-none focus:ring focus:ring-gray-100">
                                        edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $category->id }})" type="button"
                                            class="text-gray-500 capitalize text-xs transition bg-gray-200 rounded-md p-1 px-5 hover:bg-gray-300 font-bold focus:outline-none focus:ring focus:ring-gray-100">
                                        delete
                                    </button>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="4">
                                    <div class="text-xl py-8 text-gray-400 text-center">
                                        No categories found...
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
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
