<div>
    <a href="{{ route('product', ['slug' => $product->slug]) }}">
        <div class="bg-gray-100 rounded-md shadow-xl h-40 md:h-64 lg:h-72 xl:h-80 w-full bg-cover bg-center"
             style="background-image: url({{ $product->cover_image_path }})"></div>
    </a>
    <div class="flex flex-col md:flex-row md:items-start pt-3 md:p-3 space-y-1 md:space-y-0">
        <div class="flex-1 space-y-1 truncate">
            <a href="{{ route('product', ['slug' => $product->slug]) }}" class="block text-sm font-medium truncate">
                {{ $product->name }}
            </a>
{{--            <ul class="flex items-center text-gray-400 text-xs space-x-1 truncate">--}}
{{--                @foreach($product->categories as $category)--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('category', ['slug' => $category->slug]) }}"--}}
{{--                           class="hover:text-gray-600 transition">{{ $category->name }}</a>@if(!$loop->last),@endif--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
        </div>
        <div class="flex flex-col md:items-end text-sm space-y-1">
            <p>${{ $product->starting_price }}</p>
            <ul class="hidden md:flex items-center">
                <template x-for="i in 4">
                    <li>
                        <i class="mdi mdi-star text-yellow-300"></i>
                    </li>
                </template>
                <li>
                    <i class="mdi mdi-star text-gray-300"></i>
                </li>
            </ul>
        </div>
    </div>
</div>