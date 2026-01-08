@extends('layouts.app')

@section('header')
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
<h2 class="font-semibold text-2xl text-gray-800 tracking-wide">
    🛒 My Cart
</h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($cartItems->isEmpty())
        <div class="text-center py-20">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Your cart is empty!</h3>
            <a href="{{ route('shop.products') }}"
                class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded shadow hover:bg-indigo-500 transition">
                🛍 Start Shopping
            </a>
        </div>
        @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantity</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                            <span class="text-gray-900 font-medium">{{ $item->product->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                            ${{ number_format($item->product->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">

                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    class="w-16 p-1 border rounded text-center">
                                <button type="submit"
                                    class="px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500 transition">Update</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                            ${{ number_format($item->product->price * $item->quantity, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500 transition">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Cart Summary --}}
        <div class="mt-6 flex justify-end space-x-4">
            <div class="text-right">
                <p class="text-gray-700 font-medium">Total:
                    ${{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity), 2) }}</p>
                <a href="{{ route('checkout') }}"
                    class="inline-block mt-2 px-6 py-3 bg-green-600 text-white font-semibold rounded shadow hover:bg-green-500 transition">
                    Proceed to Checkout
                </a>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection