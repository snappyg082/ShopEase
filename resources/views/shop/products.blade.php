@extends('layouts.app')

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
@section('content')

<div class="py-8 max-w-7xl mx-auto px-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">
        Products
    </h1>

    {{-- Featured Products Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 py-6">
        @forelse($products as $product)
        <div
            class="group bg-gray-100 rounded-lg shadow hover:shadow-2xl transition transform hover:-translate-y-2 flex flex-col overflow-hidden">
            @php
            $imagePath = 'images/' . ($product->image ?? ('product' . $product->id . '.jpg'));
            if (!file_exists(public_path($imagePath))) {
            $png = 'images/product' . $product->id . '.png';
            if (file_exists(public_path($png))) {
            $imagePath = $png;
            } else {
            $imagePath = 'images/test.jpg';
            }
            }
            @endphp
            <img src="{{ asset($imagePath) }}"
                onerror="this.src='{{ asset('images/test.jpg') }}'"
                class="w-full h-48 object-cover border-4 border-black rounded transition-transform duration-500 group-hover:scale-105">
            <div class="p-4 flex flex-col flex-grow">
                <h3 class="mt-3 font-semibold text-xl text-gray-900">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($product->description, 50) }}</p>
                <p class="mt-2 font-bold text-green-700">${{ number_format($product->price, 2) }}</p>
                <p class="text-xs text-gray-500 mt-1">Stock: {{ $product->stock }}</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit"
                        class="mt-4 w-full bg-indigo-600 hover:bg-indigo-800 text-white font-semibold py-2 rounded transition-all duration-300 hover:scale-105">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-12">
            <p class="text-gray-600 text-lg">No products available at the moment.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection