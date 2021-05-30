<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-3 xl:grid-cols-4 lg:gap-x-10 lg:gap-y-5">
    <a href="{{ Storage::url($product->cover_image_path) }}" class="glightbox lg:col-span-2 xl:col-span-3">
        <img src="{{ Storage::url($product->cover_image_path) }}" alt="{{ $product->name }}"
             class="rounded-lg shadow border">
    </a>

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
                            <input wire:model="licenseId" class="hidden" type="radio" id="{{ $license->id }}"
                                   value="{{ $license->id }}" name="license"/>
                            <div class="radio mr-3">
                                <i class="mdi mdi-check opacity-0 transition ease-out parent-hover:opacity-100 text-white"></i>
                            </div>
                            <div class="flex-1">
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
            <x-jet-button type="button" wire:click="addToCart({{ $product->id }})"
                          class="w-full justify-center h-12">
                Add to cart
            </x-jet-button>
            <ul class="flex space-x-2">
                @if($product->play_store_url)
                    <li class="flex-1">
                        <a href="{{ $product->play_store_url }}" target="_blank"
                           class="w-full justify-center h-12 btn-secondary">
                            <img src="/img/google-play-4.svg" class="h-full" alt="Google Play">
                        </a>
                    </li>
                @endif
                @if($product->app_store_url)
                    <li class="flex-1">
                        <a href="{{ $product->app_store_url }}" target="_blank"
                           class="w-full justify-center h-12 btn-secondary">
                            <img src="/img/available-on-the-app-store.svg" class="h-10"
                                 alt="Available on the App Store">
                        </a>
                    </li>
                @endif
                @if($product->web_url)
                    <li class="flex-1">
                        <a href="{{ $product->web_url }}" target="_blank"
                           class="w-full justify-center h-12 btn-secondary">
                            Live preview
                        </a>
                    </li>
                @endif
            </ul>
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
                    🛒 {{ $product->purchases->count() }}
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
                            <a href="{{ route('category', ['slug' => $category->slug]) }}"
                               class="text-blue-400 whitespace-nowrap">
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


    {{-- Tabs Section  --}}
    <div x-data="tabs()" class="lg:col-span-2 xl:col-span-3">
        <ul class="inline-flex w-full border-b border-gray-300 select-none text-sm space-x-8">
            <template hidden x-for="item in getTabs()" :key="item">
                <li @click="setTab(item)" class="relative py-4 cursor-pointer hover:opacity-75">
                    <div :class="{ 'border-b-4 -mb-1': getActive() === item }"
                         class="absolute top-0 left-0 w-full h-full border-b-0 border-gray-900 transition-all ease-out duration-75"></div>
                    <span x-text="item" class="uppercase tracking-widest text-xs font-semibold"></span>
                </li>
            </template>
        </ul>
        <div class="py-5">
            <div x-show="getActive() === 'description'" class="trix-content">
                {!! $product->description !!}
            </div>
            <div x-show="getActive() === 'screenshots'">
                <ul class="overflow-x-auto space-x-3 whitespace-nowrap -mx-3 md:mx-0 px-3 md:px-0">
                    @foreach($product->screenshots as $screenshot)
                        <li class="inline-flex">
                            <a href="{{ Storage::url($screenshot->path) }}" class="glightbox">
                                <img src="{{ Storage::url($screenshot->path) }}" alt=""
                                     class="h-64 md:h-72 border rounded-lg shadow-sm">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div x-show="getActive() === 'reviews'">
                <p class="text-sm leading-relaxed">
                    coming soon...
                </p>
            </div>
        </div>
    </div>

    {{--  Related Templates Section  --}}
    @foreach ($product->categories as $category)
        @if($category->products->where('id', '!=', $product->id)->count() > 0)
            <section
                    class="border-t border-gray-300 py-8 flex flex-col md:flex-row flex-wrap items-start lg:col-span-full">
                <header class="flex-1">
                    <p class="text-lg font-medium">
                        {{ $category->name }}
                    </p>
                    <p class="text-gray-500 text-sm">
                        Related templates in the same category.
                    </p>
                </header>
                <a href="{{ route('category', ['slug' => $category->slug]) }}"
                   class="order-last md:order-none w-full md:w-auto btn-secondary h-10 justify-center space-x-1">
                    <span>View all</span>
                    <span class="md:hidden">related templates</span>
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
      tabs: ['description', @if (count($product->screenshots))'screenshots', @endif 'reviews'],
      getTabs() {
        return this.tabs
      },
      setTab(tab) {
        this.tab = tab
      },
      getActive() {
        return this.tab
      },
    }
  }
</script>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script type="text/javascript">
      const lightbox = GLightbox();
    </script>
@endpush

