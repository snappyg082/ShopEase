@extends('layouts.app')

@section('header')
@auth
<form action="{{ route('global.search') }}" method="GET" class="flex gap-2 justify-center py-6">
    <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}"
        class="bg-transparent text-gray-100 border border-gray-600 px-4 py-2 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">

    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
        Search
    </button>
</form>
@endauth
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <h2 class="text-2xl font-bold mb-6 text-gray-50">
        Search results for "{{ $query }}"
    </h2>

    {{-- ================= PRODUCTS ================= --}}
    @if($products->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach($products as $product)
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">

            {{-- Image --}}
            <div class="flex items-center justify-center p-4">
                @php
                $imagePath = 'images/' . ($product->image ?? 'product' . $product->id . '.jpg');
                if (!file_exists(public_path($imagePath))) {
                $imagePath = 'images/test.jpg';
                }
                @endphp

                <img src="{{ asset($imagePath) }}" onerror="this.src='{{ asset('images/test.jpg') }}'"
                    alt="{{ $product->name }}"
                    class="w-full max-h-64 object-cover rounded-lg border-4 border-indigo-600 shadow-lg hover:scale-105 transition">
            </div>

            {{-- Details --}}
            <div class="p-4">
                <h3 class="text-2xl font-bold text-gray-100 mb-2">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-gray-300 mb-4">
                    {{ $product->description }}
                </p>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-100 font-semibold">Price:</span>
                        <span class="text-xl font-bold text-green-600">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-100 font-semibold">Stock:</span>
                        <span class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? $product->stock . ' units' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ================= ORDERS ================= --}}
    @if($orders->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @foreach($orders as $order)
        <div class="p-4 bg-white shadow rounded">
            <h4 class="font-bold">Status: {{ $order->status }}</h4>
            <h4 class="font-bold">Price: ${{ number_format($order->total_price, 2) }}</h4>
            <p class="text-sm text-gray-600">
                Date: {{ $order->created_at->format('M d, Y') }}
            </p>
            <p class="text-sm text-gray-600">
                Customer: {{ $order->user->name }}
            </p>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ================= CART ITEMS ================= --}}
    @if($carts->isNotEmpty())
    <ul class="space-y-3 mb-8">
        @foreach($carts as $cart)
        <li class="p-4 bg-gray-100 rounded">
            {{ $cart->product->name }} — Qty: {{ $cart->quantity }}
        </li>
        @endforeach
    </ul>
    @endif

    {{-- ================= CHATBOT LINKS ================= --}}
    @if($isMessageSearch)
    <div class="mb-6 text-center backdrop-blur-xl p-4">
        <a href="{{ route('sms.index') }}" class="text-white font-extrabold ">
            message
        </a>
    </div>
    @endif

    @if($isChatbotSearch)
    <div class="mb-6 text-center backdrop-blur-xl p-4">
        <a href="{{ route('index') }}" class="text-white font-extrabold">
            ChatBot
        </a>
    </div>
    @endif
    {{-- -Product link --}}
    @if ($isProductSearch)
    <div class="mb-6 text-center backdrop-blur-xl p-4">
        <a href="{{ route('products.index') }}" class="text-white font-extrabold">
            Products
        </a>
    </div>
    @endif
    {{-- Cart link --}}
    @if ($isCartSearch)
    <div class="mb-6 text-center backdrop-blur-xl p-4">
        <a href="{{ route('cart.index') }}" class="text-white font-extrabold">
            Carts
        </a>
    </div>
    @endif
    {{-- Order link --}}
    @if ($isOrderSearch)
    <div class="mb-6 text-center backdrop-blur-xl p-4">
        <a href="{{ route('shop.orders') }}" class="text-white font-extrabold">
            Orders
        </a>
    </div>

    @endif
    {{-- ================= BACK LINK ================= --}}
    <div class="mt-8">
        <a href="{{ route('dashboard') }}" class="text-gray-100 hover:text-indigo-100 font-semibold">
            ← Back
        </a>
    </div>

</div>
@endsection