<nav x-data="{ open: false }" class="backdrop-blur-3xl border-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->


            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                    </a>
                </div>

                @guest
                <x-nav-link class="hover:scale-110 transition" href="{{ route('login') }} ">
                    {{ __('Login') }}
                </x-nav-link>
                <x-nav-link class="hover:scale-110 transition" href="{{ route('register') }}">|
                    {{ __('Register') }}
                </x-nav-link>
                @endguest
                <!-- Main Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <img src="{{ asset('images/home.png') }}"
                            alt="Home"
                            class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('shop.products') }}" :active="request()->routeIs('shop.products*')">
                        <img src="{{ asset('images/product.jpg') }}"
                            alt="Products"
                            class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Products') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart.*')">
                        <img src="{{ asset('images/cart.png') }}"
                            alt="Carts"
                            class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Cart') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders*')">
                        <img src="{{ asset('images/order.png') }}"
                            alt="Orders"
                            class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Order') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('index') }}" :active="request()->routeIs('index*')">
                        <img src="{{ asset('images/ai.png') }}"
                            alt="Orders"
                            class="h-6 w-6 hover:scale-150 transition">
                        {{ __('ChatBot') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('sms.index') }}" :active="request()->routeIs('Sms*')">
                        <img src="{{ asset('images/mess1.jfif') }}"
                            alt="Sms"
                            class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Messages') }}
                    </x-nav-link>


                    @endauth

                    {{-- Admin / Seller Panel --}}

                    @auth

                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'seller')
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700">
                                    Shop Management
                                    <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Shop') }}
                                </div>

                                <x-dropdown-link href="{{ route('admin.products.index') }}">
                                    {{ __('Products') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('admin.orders.index') }}">
                                    {{ __('Orders') }}
                                </x-dropdown-link>

                                @if (Auth::user()->role === 'admin')
                                <x-dropdown-link href="{{ route('admin.users.index') }}">
                                    {{ __('Users') }}
                                </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium border-none text-gray-100 bg-transparent hover:text-slate-400">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs backdrop-blur-md text-slate-300">
                                {{ __('Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.edit') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth

            </div>

            <!-- HAMBURGER -->
            @auth
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endauth
    @auth
    <!-- MOBILE MENU -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <img src="{{ asset('images/home.png') }}"
                    alt="Home"
                    class="h-6 w-6 hover:scale-110 transition">
                {{ __('Home') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('shop.products') }}" :active="request()->routeIs('shop.products*')">
                <img src="{{ asset('images/product.jpg') }}"
                    alt="Products"
                    class="h-6 w-6 hover:scale-110 transition">
                {{ __('Products') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart.*')">
                <img src="{{ asset('images/cart.png') }}"
                    alt="Carts"
                    class="h-6 w-6 hover:scale-110 transition">
                {{ __('Cart') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders*')">
                <img src="{{ asset('images/order.png') }}"
                    alt="Orders"
                    class="h-6 w-6 hover:scale-110 transition">
                {{ __('Order') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('index') }}" :active="request()->routeIs('index*')">
                <img src="{{ asset('images/ai.png') }}"
                    alt="Chatbot"
                    class="h-6 w-6 hover:scale-110 transition">
                {{ __('ChatBot') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('sms.index') }}" :active="request()->routeIs('Sms*')">
                <img src="{{ asset('images/mess1.jfif') }}"
                    alt="Sms"
                    class="h-6 w-6 hover:scale-110 transition">
                {{ __('Message') }}
            </x-responsive-nav-link>

        </div>
        @endauth

        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">

                <div class="relative inline block font-meduim text-base text-gray-800">
                    {{ Auth::user()->name }}
                    <span class="absolute ml-2 mt-2 w-2.5 h-2.5 bg-green-500 rounded-full "></span>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.edit') }}">Profile</x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
            @endauth
        </div>
</nav>