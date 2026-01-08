@extends('layouts.app')

@section('content')
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
@endsection
<div class="py-8 max-w-7xl mx-auto px-6">
    <h1 class="text-3xl font-bold bg-gradient-to-r from-red-500 to-blue-600 mb-6 rounded-lg text-center text-slate-800">Products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


        @forelse($products as $product)
        @php
        // Build image path: prefer explicit product image if present, else fallback to product{id}.jpg then test.jpg
        $imagePath = 'images/' . ($product->image ?? ('product' . $product->id . '.jpg'));
        if(!file_exists(public_path($imagePath))){
        $imagePath = 'images/product' . $product->id . '.jpg';
        if(!file_exists(public_path($imagePath))){
        $imagePath = 'images/test.jpg';
        }
        }
        @endphp

        <a href="{{ route('product.show', $product->id) }}" class="group">
            <div class="backdrop-blur-md rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col h-full hover:scale-105 duration-300">
                <img src="{{ asset($imagePath) }}"
                    onerror="this.src='{{ asset('images/test.jpg') }}'"
                    class="w-full h-48 object-cover border-black border-4 rounded group-hover:border-indigo-600 transition">
                <h3 class="mt-4 font-semibold text-xl text-gray-900 group-hover:text-indigo-600">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($product->description, 60) }}</p>
                <p class="mt-2 font-bold text-green-600 text-lg">${{ number_format($product->price, 2) }}</p>
                <p class="text-xs text-gray-500 mt-1">Stock: {{ $product->stock }}</p>
            </div>
        </a>
        @empty
        <div class="col-span-4 text-center py-12">
            <p class="text-gray-600 text-lg">No products available.</p>
        </div>
        @endforelse
    </div>
</div>


@endsection