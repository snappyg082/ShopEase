@extends('layouts.app')

@section('header')
@auth
<form action="{{ route('global.search') }}" method="GET" class="flex gap-2 justify-center py-6">
    <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}"
        class="bg-transparent text-gray-100 border border-gray-600 px-4 py-2 rounded-lg w-full max-w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
        Search
    </button>
</form>
@endauth
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <h2 class="text-2xl font-bold mb-6">
        Search results for "{{ $query }}"
    </h2>

    @if ($products->isEmpty() && $orders->isEmpty() && $carts->isEmpty() && $sms->isEmpty() && $messages->isEmpty())
    <p class="text-gray-600">No results found.</p>
    @endif

    {{-- Products --}}
    @if($products->isNotEmpty())
    <div class="grid grid-cols-auto md:grid-cols-auto gap-4 mb-8">
        @foreach($products as $product)
        {{-- your existing product card code --}}

        {{-- Product Image --}}
        <div class="flex items-center justify-center">
            @php
            // Prefer explicit product image if set; otherwise use product{id}.jpg then test.jpg
            $imagePath = 'images/' . ($product->image ?? ('product' . $product->id . '.jpg'));
            if(!file_exists(public_path($imagePath))){
            $imagePath = 'images/product' . $product->id . '.jpg';
            if(!file_exists(public_path($imagePath))){
            $imagePath = 'images/test.jpg';
            }
            }
            @endphp
            <img src="{{ asset($imagePath) }}" onerror="this.src='{{ asset('images/test.jpg') }}'"
                alt="{{ $product->name }}"
                class="w-full h-auto max-h-96 object-cover rounded-lg border-4 border-indigo-600 shadow-lg hover:scale-105 transition duration-300">
        </div>

        {{-- Product Details --}}
        <div class="flex flex-col justify-between">

            {{-- Product Header --}}
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    {{ $product->name }}
                </h1>

                <p class="text-lg text-gray-600 mb-6">
                    {{ $product->description }}
                </p>

                {{-- Product Info --}}
                <div class="space-y-4 mb-8 pb-8 border-b border-gray-300">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-semibold">Price:</span>
                        <span class="text-4xl font-bold text-green-600">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-semibold">Available Stock:</span>
                        <span
                            class="text-lg font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? $product->stock . ' units' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
        @endif

        {{-- Orders --}}
        @if($orders->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            @foreach($orders as $order)
            <div class="p-4 bg-white shadow rounded">
                <h4 class="font-bold">Status: {{ $order->status }}</h4>
                <h4 class="font-bold">Price: ${{ number_format($order->total_price, 2) }}</h4>
                <p class="text-sm text-gray-600">Date: {{ $order->created_at->format('M d, Y') }}</p>
                <p class="text-sm text-gray-600">Customer: {{ $order->user->name }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Cart Items --}}
        @if($carts->isNotEmpty())
        <ul class="space-y-3 mb-8">
            @foreach($carts as $cart)
            <li class="p-4 bg-gray-100 rounded">
                {{ $cart->product->name }} — Qty: {{ $cart->quantity }}
            </li>
            @endforeach
        </ul>
        @endif

        {{-- Results --}}
        @if($sms->isNotEmpty())
        <div class="mb-8">
            <ul class="space-y-3">
                <li class="p-4 backdrop-blur-md text-center rounded shadow-sm">
                    <a href="{{ route('sms.index') }}"
                        class="text-indigo-600 font-extrabold  ">
                        {{ __('Message') }}
                    </a>
                </li>
            </ul>
        </div>

        @elseif($messages->isNotEmpty())
        <div class="mb-8">
            <ul class="space-y-3">
                <li class="p-4 backdrop-blur-md text-center rounded shadow-sm">
                    <a href="{{ route('index') }}"
                        class="text-indigo-600 font-extrabold ">
                        {{ __('ChatBot') }}
                    </a>
                </li>
            </ul>
        </div>

        @else
        <p class="text-gray-600">No results found.</p>
        @endif

        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-gray-900 hover:text-indigo-100 font-semibold">
                ← Back
            </a>
        </div>

        @endsection