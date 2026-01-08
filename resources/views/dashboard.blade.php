@extends('layouts.app')

{{-- Header --}}
@section('header')
{{-- Centered Search Box --}}
@auth
<form action="{{ route('global.search') }}" method="GET" class="flex gap-2 justify-center py-6">
    <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}"
        class="bg-transparent text-gray-100 border border-gray-600 px-4 py-2 rounded-lg w-full max-w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
        Search
    </button>
</form>
@endauth

{{-- Display error message --}}
@if(session('error'))
<p class="text-red-600 mt-2">{{ session('error') }}</p>
@endif
@endsection

{{-- Page Content --}}
@section('content')

@guest
{{-- Content for logged-out users --}}
<div class="flex items-center justify-center py-24 bg-transparent">
    <img src="{{ asset('images/loginBackground.png') }}" alt="Website Logo" class="w-100 md:w-80 rounded shadow-lg">
</div>
@else

{{-- Dashboard content for logged-in users --}}
<div class="py-8 space-y-10">
    {{-- Welcome Card --}}
    <div
        class="bg-gradient-to-r from-red-500 to-blue-600 text-white shadow-lg rounded-xl p-6 flex flex-col sm:flex-row justify-between items-center ">
        <div class="relative inline block font-meduim text-base">
            <h3 class="text-2xl font-bold">
                Welcome, {{ Auth::user()->name }} <span class="absolute ml-2 mt-2.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></span>
            </h3>

            <p class="mt-2 text-indigo-100">
                Browse products, manage your cart, and track your orders.
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('shop.products') }}"
                class="inline-block px-5 py-2 bg-white text-indigo-600 font-semibold rounded shadow hover:shadow-2xl transition transform hover:-translate-x-4 flex flex-col overflow-hidden">
                🛍 Start Shopping
            </a>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <a href="{{ route('shop.products') }}"
            class="bg-gradient-to-l from-red-500 to-blue-600 hover:shadow-2xl transition transform hover:-translate-y-2 flex flex-col overflow-hidden text-white p-6 flex flex-col justify-center items-center text-center">
            <span class="text-3xl mb-2">🛍</span>
            <span class="font-semibold">View Products</span>
        </a>

        <a href="{{ route('shop.carts') }}"
            class="bg-gradient-to-r from-green-500 to-red-600 hover:shadow-2xl transition transform hover:-translate-y-2 flex flex-col overflow-hidden text-white p-6 flex flex-col justify-center items-center text-center">
            <span class="text-3xl mb-2">🛒</span>
            <span class="font-semibold">My Cart</span>
        </a>

        <a href="{{ route('shop.orders') }}"
            class="bg-gradient-to-r from-yellow-500 to-red-600 hover:shadow-2xl transition transform hover:-translate-y-2 flex flex-col overflow-hidden text-white p-6 flex flex-col justify-center items-center text-center">
            <span class="text-3xl mb-2">📦</span>
            <span class="font-semibold">My Orders</span>
        </a>
    </div>

    {{-- Featured Products --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="backdrop-blur-xl p-6 rounded-lg shadow hover:bg-gradient-to-r from-slate-800 to-slate-50 hover:scale-105 transition duration-300">
            <img src="{{ asset('images/product3.jpg') }}"
                class="w-full h-48 object-cover border-4 border-black rounded">
            <h3 class="mt-3 font-semibold text-xl text-gray-900">Headphones</h3>
            <p class="mt-2 font-bold text-green-700">$150</p>
        </div>

        <div class="backdrop-blur-xl p-6 rounded-lg shadow hover:bg-gradient-to-r from-yellow-600 to-violet-600 hover:scale-105 transition duration-300">
            <img src="{{ asset('images/product1.png') }}"
                class="w-full h-48 object-cover border-4 border-black rounded">
            <h3 class="mt-3 font-semibold text-xl text-gray-900">Laptops</h3>
            <p class="mt-2 font-bold text-green-700">$1,200</p>
        </div>

        <div class="backdrop-blur-xl p-6 rounded-lg shadow hover:bg-gradient-to-r from-pink-600 to-sky-700 hover:scale-105 transition duration-300">
            <img src="{{ asset('images/product2.png') }}"
                class="w-full h-48 object-cover border-4 border-black rounded">
            <h3 class="mt-3 font-semibold text-xl text-gray-900">Smartphones</h3>
            <p class="mt-2 font-bold text-green-700">$800</p>
        </div>

        <div class="backdrop-blur-xl p-6 rounded-lg shadow hover:bg-gradient-to-r from-blue-600 to-red-600 hover:scale-105 transition duration-300">
            <img src="{{ asset('images/product4.png') }}"
                class="w-full h-48 object-cover border-4 border-black rounded">
            <h3 class="mt-3 font-semibold text-xl text-gray-900">Gaming PC</h3>
            <p class="mt-2 font-bold text-green-700">$2,000</p>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="backdrop-blur-2xl dark:bg-gray-800 shadow rounded-lg p-6">
        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Recent Orders
        </h4>

        @forelse($recentOrders as $order)
        <div class="flex justify-between items-center border-b last:border-b-0 py-3">
            <span class="font-semibold text-gray-900 dark:text-gray-100">
                {{ $order->product?->name ?? 'N/A' }}
            </span>
            <span class="text-slate-800">
                {{ $order->created_at->diffForHumans() }}
            </span>
            <span class="font-semibold text-green-800">
                ${{ $order->total_price }}
            </span>
        </div>
        @empty
        <p class="text-gray-100 dark:text-gray-300">
            You have no recent orders.
        </p>
        @endforelse
    </div>

</div>
</div>
@endguest

@endsection