<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 space-y-3">
                <div class="flex">
                    <x-jet-input class="block text-sm" type="text" placeholder="Search..." wire:model="search"/>
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
                            <x-table.row wire:loading.class.delay="opacity-50" class="transition">
                                <x-table.cell>
                                    {{ $category->order }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $category->name }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $category->updated_at_for_humans }}
                                </x-table.cell>
                                <x-table.cell class="flex justify-end">
                                    <button type="button" class="text-gray-500 capitalize text-xs transition bg-gray-200 rounded-md p-1 px-5 hover:bg-gray-300 font-bold">
                                        edit
                                    </button>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="3">
                                    <div class="text-xl py-8 text-gray-400 flex items-center justify-center space-x-2">
                                        <i class="mdi mdi-lightbulb-group text-4xl "></i>
                                        <span>No $categories found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-table>

                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
