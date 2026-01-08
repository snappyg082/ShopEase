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
<div class="py-12 max-w-6xl mx-auto px-6">

    {{-- Breadcrumb --}}
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-gray-900 hover:text-indigo-100 font-semibold">
            ← Back to Products
        </a>
    </div>

    {{-- Product Detail Container --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white rounded-lg shadow-lg p-8">

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
            <img src="{{ asset($imagePath) }}"
                onerror="this.src='{{ asset('images/test.jpg') }}'"
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
                        <span class="text-lg font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? $product->stock . ' units' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Add to Cart Action --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                @csrf
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                    🛒 Add to Cart
                </button>
            </form>
            @else
            <button disabled
                class="w-full bg-gray-400 text-white font-bold py-4 rounded-lg cursor-not-allowed opacity-50">
                Out of Stock
            </button>
            @endif

            {{-- Related Actions --}}
            <div class="mt-6 flex gap-4">
                <a href="{{ route('products.index') }}"
                    class="flex-1 text-center bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold py-3 rounded-lg transition">
                    Continue Shopping
                </a>
                <a href="{{ route('cart.index') }}"
                    class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg transition">
                    View Cart
                </a>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">More Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
            $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)->take(4)->get();
            @endphp
            @forelse($relatedProducts as $related)
            <a href="{{ route('product.show', $related->id) }}" class="block group">
                @php
                $relatedImagePath = 'images/' . ($related->image ?? ('product' . $related->id . '.jpg'));
                if(!file_exists(public_path($relatedImagePath))){
                $relatedImagePath = 'images/product' . $related->id . '.jpg';
                if(!file_exists(public_path($relatedImagePath))){
                $relatedImagePath = 'images/test.jpg';
                }
                }
                @endphp
                <div class="bg-white rounded-lg shadow hover:shadow-xl transition p-4 flex flex-col h-full">
                    <img src="{{ asset($relatedImagePath) }}"
                        onerror="this.src='{{ asset('images/test.jpg') }}'"
                        alt="{{ $related->name }}"
                        class="w-full h-40 object-cover rounded-md border-2 border-gray-200 group-hover:border-indigo-600 transition">
                    <h3 class="mt-4 font-semibold text-lg text-gray-900 group-hover:text-indigo-600">
                        {{ $related->name }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-2">
                        {{ Str::limit($related->description, 50) }}
                    </p>
                    <p class="mt-4 font-bold text-green-600">
                        ${{ number_format($related->price, 2) }}
                    </p>
                </div>
            </a>
            @empty
            <p class="text-gray-600 col-span-4 text-center">No other products available.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Add to Cart with feedback
    const form = document.querySelector('.add-to-cart-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert('✅ ' + (data.message || 'Product added to cart!'));
                    // Optionally redirect to cart
                    // window.location.href = '{{ route("cart.index") }}';
                })
                .catch(err => {
                    // Fallback to regular form submission
                    form.submit();
                });
        });
    }
</script>
@endsection