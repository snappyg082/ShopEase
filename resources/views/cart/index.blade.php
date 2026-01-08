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
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-100">
                🛒 Your Cart
            </h1>
        </div>

        {{-- Empty Cart --}}
        @if($cartItems->isEmpty())
        <div class="bg-transparent shadow rounded-xl p-10 text-center">
            <p class="text-gray-300 text-lg">Your cart is empty.</p>
            <a href="{{ route('shop.products') }}"
                class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition">
                🛍 Start Shopping
            </a>
        </div>
        @else

        {{-- Cart Table --}}
        <div class="backdrop-blur-3xl shadow rounded-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="backdrop-blur-3xl">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Product
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Price
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Quantity
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Total
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <tr class="hover:bg-slate-500 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->product->name }}
                        </td>
                        <td class="px-6 py-4 text-green-900">
                            ${{ number_format($item->product->price, 2) }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            <form action="{{ route('cart.update', $item->product->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <select name="quantity"
                                    onchange="this.form.submit()"
                                    class="px-3 py-1 border border-gray-300 rounded bg-white text-gray-900 cursor-pointer">
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                        </option>
                                        @endfor
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 font-semibold text-green-900">
                            ${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:scale-110 transition ease-in-out">
                                    Remove
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Place Order Button --}}
            <div class="p-6 text-right">
                <form action="{{ url('/orders/create') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:scale-110 transition ease-in-out">
                        ✅ Place Order
                    </button>
                </form>
            </div>
        </div>

        @endif

    </div>
</div>
@endsection