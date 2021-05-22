<div class="container py-5 lg:py-10 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-3 xl:grid-cols-4 lg:gap-x-10 lg:gap-y-5">

    <div class="bg-gray-300 rounded shadow-xl lg:col-span-2 xl:col-span-3 bg-cover bg-center"
         style="background-image: url({{ $product->cover_image_path }})">
        <div class="h-72"></div>
        <div class="lg:h-40 xl:h-72"></div>
    </div>

    <h1 class="font-medium text-xl lg:text-3xl lg:col-span-full lg:row-start-1">
        {{ $product->name }}
    </h1>

    <div class="space-y-6 lg:col-start-3 xl:col-start-4 lg:row-start-2 lg:row-end-4">
        <div class="flex items-center justify-between">
            <p class="font-medium">
                License Options
            </p>
            <a href="#" class="text-xs text-blue-400">
                Full details
                <i class="mdi mdi-arrow-right"></i>
            </a>
        </div>
        <ul class="space-y-6">
            @foreach($product->licenses as $license)
                <li>
                    <label for="{{ $license->id }}" class="flex items-center parent cursor-pointer">
                        <div class="flex items-center">
                            <input class="hidden" type="radio" id="{{ $license->id }}" value="{{ $license->id }}"
                                   @if($loop->first) checked @endif name="license"/>
                            <div class="radio mr-3">
                                <i class="mdi mdi-check opacity-0 transition ease-out parent-hover:opacity-100 text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">
                                    {{ $license->name }}
                                </p>
                                <p class="text-xs text-gray-400 font-medium">
                                    {{ $license->summary }}
                                </p>
                            </div>
                        </div>
                        <div class="ml-auto text-xl font-medium">
                            ${{ $license->pivot->price }}
                        </div>
                    </label>
                </li>
            @endforeach
        </ul>
        <div class="space-y-3">
            <ul class="flex space-x-2">
                @if($product->play_store_url)
                    <li class="flex-1">
                        <a href="{{ $product->play_store_url }}" target="_blank" class="h-12 flex justify-center rounded p-2 bg-gray-200 transition hover:bg-gray-300">
                            <img src="/img/google-play-4.svg" class="h-full" alt="">
                        </a>
                    </li>
                @endif
                @if($product->app_store_url)
                    <li class="flex-1">
                        <a href="{{ $product->app_store_url }}" target="_blank" class="rounded border border-black h-12 p-1 flex justify-center transition hover:opacity-75">
                            <img src="/img/available-on-the-app-store.svg" class="h-full" alt="">
                        </a>
                    </li>
                @endif
                @if($product->web_url)
                    <li class="flex-1">
                        <a href="{{ $product->web_url }}" target="_blank" class="rounded border border-green-700 hover:border-green-900 transition text-green-700 text-center hover:text-green-900 h-12 flex items-center justify-center px-2 text-sm font-medium">
                            Live preview
                        </a>
                    </li>
                @endif
            </ul>
            <button type="button" class="w-full rounded bg-green-700 hover:bg-green-900 transition focus:outline-none text-white h-12 px-4 font-medium">
                Add to cart
            </button>
        </div>

        <div class="flex divide-x">
            <div class="flex-1 flex flex-col items-center py-5">
                <ul class="flex items-center">
                    <template x-for="i in 4">
                        <li>
                            <i class="mdi mdi-star text-yellow-300"></i>
                        </li>
                    </template>
                    <li>
                        <i class="mdi mdi-star text-gray-300"></i>
                    </li>
                </ul>
                <p class="text-xs text-gray-400">
                    (2 reviews)
                </p>
            </div>
            <div class="flex-1 flex flex-col items-center py-5">
                <p class="text-xl font-medium">
                    🛒60
                </p>
                <p class="text-xs text-gray-400">
                    Purchases
                </p>
            </div>
        </div>

        <ul class="text-sm">
            <li class="bg-gray-100">
                <div class="flex items-center justify-between p-3">
                    <p class="font-medium">
                        Released
                    </p>
                    <p class="text-gray-400">
                        @diffdateforhumans($product->created_at)
                    </p>
                </div>
            </li>
            <li class="">
                <div class="flex items-center justify-between p-3">
                    <p class="font-medium">
                        Updated
                    </p>
                    <p class="text-gray-400">
                        @diffdateforhumans($product->updated_at)
                    </p>
                </div>
            </li>
            <li class="bg-gray-100">
                <div class="flex items-center justify-between p-3">
                    <p class="font-medium">
                        Version
                    </p>
                    <p class="text-gray-400">
                        v1.0.0
                    </p>
                </div>
            </li>
            <li class="">
                <div class="flex items-center justify-between p-3 space-x-3">
                    <p class="font-medium">
                        Category
                    </p>
                    <div class="text-right">
                        @foreach($product->categories as $category)
                            <a href="{{ route('category', ['slug' => $category->slug]) }}" class="text-blue-400 whitespace-nowrap">
                                {{ $category->name }}@if(!$loop->last),@endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>
            <li class="bg-gray-100">
                <div class="flex items-center justify-between p-3">
                    <p class="font-medium">
                        Questions?
                    </p>
                    <a href="mailto:rayehizoba@gmail.com" class="text-blue-400">
                        Contact Us
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <div x-data="tabs()" class="lg:col-span-2 xl:col-span-3">
        <ul class="inline-flex w-full border-b select-none text-sm">
            <template x-for="item in getTabs()" :key="item">
                <li @click="setTab(item)" :class="getActive() === item ? 'border-green-700' : 'opacity-50 hover:opacity-100'"
                    class="px-4 py-2 capitalize transition-all ease-out cursor-pointer border-b-2 border-white" x-text="item">
                </li>
            </template>
        </ul>
        <div class="py-5">
            <div x-show="getActive() === 'description'" class="trix-content">
                {!! $product->description !!}
            </div>
            <div x-show="getActive() === 'screenshots'">
                <p class="text-sm leading-relaxed">
                    coming soon...
                </p>
            </div>
            <div x-show="getActive() === 'reviews'">
                <p class="text-sm leading-relaxed">
                    coming soon...
                </p>
            </div>
        </div>
    </div>

    {{--  Related Templates  --}}
    @foreach ($product->categories as $category)
        @if($category->products->where('id', '!=', $product->id)->count() > 0)
            <section class="border-t py-8 flex flex-col md:flex-row flex-wrap items-start lg:col-span-full">
                <header class="flex-1">
                    <p class="text-lg font-medium">
                        {{ $category->name }}
                    </p>
                    <p class="text-gray-500 text-sm">
                        Related templates in the same category.
                    </p>
                </header>
                <a href="{{ route('category', ['slug' => $category->slug]) }}" class="order-last md:order-none w-full md:w-auto text-center rounded border border-green-700 bg-green-700 md:bg-transparent p-3 px-4 text-white md:text-green-700 text-sm md:text-xs font-medium transition hover:border-green-800 hover:bg-green-800 md:hover:bg-transparent md:hover:text-green-800">
                    View all <span class="md:hidden">related templates</span>
                </a>
                <ul class="grid grid-cols-2 xl:grid-cols-3 gap-6 w-full my-6">
                    @foreach($category->products->where('id', '!=', $product->id)->take(4) as $each)
                        <li class="@if($loop->index > 1) hidden lg:block @endif">
                            <x-product-card :product="$each"/>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    @endforeach

</div>

<script>
  function tabs() {
    return {
      tab: 'description',
      tabs: ['description', 'screenshots', 'reviews'],
      getTabs() { return this.tabs },
      setTab(tab) { this.tab = tab },
      getActive() { return this.tab },
    }
  }
</script>
