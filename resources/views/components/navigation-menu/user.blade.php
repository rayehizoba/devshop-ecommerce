@php
    $categories = App\Models\Category::orderBy('order')->get();
@endphp

<nav class="border-b border-gray-100" x-data="{
auth: false,
account_dialog: false,
category_dialog: false,
}">
    <div class="container mx-auto py-3 flex flex-col lg:flex-row items-center lg:space-x-10 space-y-2 lg:space-y-0">
        <a href="{{ route('home.page') }}" class="font-bold text-xl md:text-2xl self-start lg:self-auto">
            devshop
        </a>
        <ul class="w-full flex flex-1 items-center justify-center lg:justify-start space-x-3 md:space-x-6 text-gray-500 text-sm md:text-base relative h-9">
            <li class="md:relative">
                {{-- Product Categories Menu --}}
                <div @click="category_dialog = true" class="cursor-pointer transition hover:text-gray-800">
                    Categories
                </div>
                <div x-show="category_dialog" x-cloak
                     class="origin-top lg:origin-top-left absolute left-0 w-full md:w-64 rounded-b-md shadow-xl z-10 mt-2"
                     x-transition:enter="transition-gpu ease-out  duration-100 transform"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75 transform"
                     x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div @click.away="category_dialog = false"
                         class="bg-white rounded-md shadow-xs text-gray-500 border border-gray-300 px-6 text-sm">
                        <ul class="space-y-4 py-5">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('category', ['slug' => $category->slug]) }}" class="hover:text-gray-900">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </li>
            <li class="hidden md:inline">
                <a href="#" class="transition hover:text-gray-800">Why Our Templates?</a>
            </li>
            <li>
                <a href="#" class="transition hover:text-gray-800">The Guide</a>
            </li>
            <li class="flex flex-1"></li>
            <li>
                <button type="button" class="lg:text-xl focus:outline-none">
                    🔍
                </button>
            </li>

            {{-- Cart Button --}}
            @if(\Cart::getContent()->count() > 0)
                <li>
                    <a href="{{ route('cart.page') }}"
                       class="flex items-center justify-center space-x-1 w-9 lg:w-12 h-9 lg:h-12 bg-blue-100 hover:bg-blue-50 transition border-2 border-transparent hover:border-blue-300 hover:text-blue-500 rounded-full focus:outline-none text-sm font-bold">
                        <span class="lg:text-lg">🛒</span>
                        <span>{{ \Cart::getContent()->count() }}</span>
                    </a>
                </li>
            @endif
            <li>
                <a x-show="!auth" href="{{ route('login') }}" class="transition hover:text-gray-800">
                    Sign in
                </a>

                {{-- User Account Menu --}}
                <div x-show="auth" x-cloak class="md:relative">
                    <div @click="account_dialog = true"
                         class="cursor-pointer h-7 md:h-8 w-7 md:w-8 bg-gray-400 rounded-full flex items-center justify-center text-xs lg:text-sm font-medium shadow-lg text-white">
                        RE
                    </div>
                    <div x-show="account_dialog"
                         class="origin-top lg:origin-top-right absolute right-0 w-full md:w-64 rounded-b-md shadow-xl z-10 mt-2"
                         x-transition:enter="transition-gpu ease-out  duration-100 transform"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75 transform"
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                        <div @click.away="account_dialog = false"
                             class="bg-white rounded-md shadow-xs text-gray-500 border px-5 text-sm">
                            <ul class="space-y-3 py-3">
                                <li>
                                    <a href="#" class="flex items-center space-x-1">
                                        <i class="mdi mdi-account text-blue-700 text-lg"></i>
                                        <span>Account</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center space-x-1">
                                        <i class="mdi mdi-logout text-blue-700 text-lg"></i>
                                        <span>Log out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li x-show="!auth" x-cloak class="hidden md:inline">
                <a href="./register.html" class="transition hover:text-gray-800">
                    Sign up
                </a>
            </li>
        </ul>
    </div>
</nav>
