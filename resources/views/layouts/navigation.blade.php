<nav x-data="{ open: false }" class="backdrop-blur-3xl border-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- LEFT SIDE -->
            <div class="flex items-center">

                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-6">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/loginBackground.png') }}" alt="Logo" class="h-6 w-auto border rounded-xl">
                    </a>
                </div>

                <!-- Guest Links -->
                @guest
                <div class="flex space-x-4">
                    <x-nav-link href="{{ route('login') }}" class="hover:scale-110 transition">Login</x-nav-link>
                    <x-nav-link href="{{ route('register') }}" class="hover:scale-110 transition">Register</x-nav-link>
                </div>
                @endguest

                <!-- Authenticated Links -->
                @auth
                <div class="hidden sm:flex sm:items-center sm:space-x-8 sm:ml-10">

                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <img src="{{ asset('images/home.png') }}" class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Home') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('shop.products') }}" :active="request()->routeIs('shop.products*')">
                        <img src="{{ asset('images/product.jpg') }}" class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Products') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart.*')">
                        <img src="{{ asset('images/cart.png') }}" class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Cart') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders*')">
                        <img src="{{ asset('images/order.png') }}" class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Order') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('index') }}" :active="request()->routeIs('index*')">
                        <img src="{{ asset('images/ai.png') }}" class="h-6 w-6 hover:scale-150 transition">
                        {{ __('ChatBot') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('sms.index') }}" :active="request()->routeIs('Sms*')">
                        <img src="{{ asset('images/mess1.jfif') }}" class="h-6 w-6 hover:scale-150 transition">
                        {{ __('Messages') }}
                    </x-nav-link>

                    <!-- Admin / Seller Dropdown -->
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'seller')
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">
                                Shop Management
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('admin.products.index') }}">Products</x-dropdown-link>
                            <x-dropdown-link href="{{ route('admin.orders.index') }}">Orders</x-dropdown-link>
                            @if(Auth::user()->role === 'admin')
                            <x-dropdown-link href="{{ route('admin.users.index') }}">Users</x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>
                    @endif

                </div>
                @endauth

            </div>

            <!-- RIGHT SIDE -->
            @auth
            <div class="flex items-center gap-4">

                <!-- Desktop Profile Dropdown -->
                <div class="hidden sm:flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm font-medium text-gray-100 hover:text-slate-400">

                                @if(Auth::user()->profile_photo_path)
                                <img src="{{ Auth::user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover">
                                @elseif(Auth::user()->image)
                                <img src="{{ asset('userImage/' . Auth::user()->image) }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-600 text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                @endif

                                <span>{{ Auth::user()->name }}</span>

                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.edit') }}">Profile</x-dropdown-link>
                            <div class="border-t"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Hamburger -->
                <div class="sm:hidden">
                    <button @click="open = !open" class="p-2 text-gray-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open }" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open }" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
            @endauth

        </div>

        <!-- MOBILE MENU -->
        @auth
        <div x-show="open" class="sm:hidden">
            <div class="pt-4 pb-3 border-t">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Home</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('shop.products') }}" :active="request()->routeIs('shop.products*')">Products</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('cart.index') }}" :active="request()->routeIs('cart.*')">Cart</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders*')">Orders</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('index') }}" :active="request()->routeIs('index*')">ChatBot</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('sms.index') }}" :active="request()->routeIs('Sms*')">Messages</x-responsive-nav-link>

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
        </div>
        @endauth

    </div>
</nav>