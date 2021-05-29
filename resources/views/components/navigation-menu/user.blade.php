@php
    $categories = App\Models\Category::orderBy('order')->get();
@endphp

<nav class="border-b border-gray-100 select-none" x-data="{account_dialog: false, category_dialog: false,}">
    <div class="container mx-auto py-3 flex flex-col lg:flex-row items-center lg:space-x-10 space-y-2 lg:space-y-0">
        <a href="{{ route('home.page') }}" class="font-bold text-xl md:text-2xl self-start lg:self-auto">
            devshop
        </a>
        <ul class="w-full flex flex-1 items-center justify-center lg:justify-start space-x-4 md:space-x-6 text-gray-500 text-sm md:text-base relative">
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
                         class="bg-white rounded-md shadow-xs text-gray-500 border py-1 text-sm">
                        <ul class="divide-y">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('category', ['slug' => $category->slug]) }}"
                                       class="block py-2 hover:bg-gray-100 px-5 transition">
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
            {{-- Cart Button --}}
            @if(\Cart::getContent()->count() > 0)
                <li>
                    <a href="{{ route('cart.page') }}" class="text-blue-500 font-semibold">
                        Cart ({{ \Cart::getContent()->count() }})
                    </a>
                </li>
            @endif

            <li>
                @if(!Auth::check() && Route::has('login'))
                    <a href="{{ route('login') }}" class="transition hover:text-gray-800">
                        {{ _('Sign in') }}
                    </a>
                @endif
                @if(Auth::check())
                    {{-- User Account Menu --}}
                    <div class="md:relative">
                        <div @click="account_dialog = true"
                             class="cursor-pointer h-7 md:h-8 w-7 md:w-8 bg-blue-500 rounded-full flex items-center justify-center text-xs lg:text-sm font-semibold shadow-lg text-white">
                            RE
                        </div>
                        <div x-cloak x-show="account_dialog"
                             class="origin-top lg:origin-top-right absolute right-0 w-full md:w-auto rounded-b-md shadow-xl z-10 mt-2"
                             x-transition:enter="transition-gpu ease-out  duration-100 transform"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75 transform"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">
                            <div @click.away="account_dialog = false"
                                 class="bg-white rounded-md shadow-xs text-gray-900 border text-sm py-1">
                                <p class="text-xs text-gray-400 px-5 py-2">
                                    {{ Auth::user()->name }}
                                </p>
                                <ul class="divide-y">
                                    <li>
                                        <a href="{{ route('profile.show') }}"
                                           class="flex items-center space-x-1 hover:bg-gray-100 py-1 px-5 md:pr-20 transition">
                                            <i class="mdi mdi-account text-blue-500 text-lg"></i>
                                            <span>Account</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                               class="flex items-center space-x-1 hover:bg-gray-100 py-1 px-5 md:pr-20 transition"
                                               onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                                <i class="mdi mdi-logout text-blue-500 text-lg"></i>
                                                <span>{{ __('Log Out') }}</span>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </li>

            @if(!Auth::check() && Route::has('register'))
                <li class="hidden md:inline">
                    <a href="{{ route('register') }}" class="transition hover:text-gray-800">
                        {{ __('Sign up') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
