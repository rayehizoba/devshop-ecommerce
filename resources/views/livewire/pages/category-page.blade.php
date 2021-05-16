<div class="container space-y-5 divide-y">
    <section class="pt-8 flex flex-col md:flex-row flex-wrap items-start divide-y space-y-6">
        <header class="flex-1 flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 w-full">
            <div>
                <p class="text-gray-500 text-xs">
{{--                    Now Showing:--}}
                    Category
                </p>
                <p class="text-2xl font-medium">
{{--                    All Templates--}}
                    {{ $category->name }}
                </p>
            </div>
            <div>
                <select wire:model="orderby"
                        class="bg-white rounded border w-full md:w-auto p-2 text-sm focus:outline-none focus:ring pr-8 text-gray-500">
                    @foreach(Config::get('constants.options.orderby') as $key => $value)
                        <option value="{{ $value }}">
                            {{ $key }}
                        </option>
                    @endforeach
                </select>
            </div>
        </header>
        <ul class="grid grid-cols-2 xl:grid-cols-3 gap-6 w-full py-6">
            @forelse ($products as $product)
                <li>
                    <x-product-card :product="$product"/>
                </li>
            @empty
                <div class="col-span-2 xl:col-span-3 text-center py-20">
                    <p class="text-2xl">
                        No Products
                    </p>
                    <p class="text-sm text-gray-500">
                        No templates found in this category
                    </p>
                    <a href="{{ route('shop') }}" class="btn-outline inline-block mt-3">
                        Explore Templates
                    </a>
                </div>
            @endforelse
            <li class="col-span-2 xl:col-span-3">
                {{ $products->links() }}
            </li>
        </ul>
    </section>
</div>
