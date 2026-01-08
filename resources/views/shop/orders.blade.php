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
@endsection




{{-- Page Content --}}
@section('content')

<h2 class="font-semibold text-2xl text-gray-800 tracking-wide py-3 ml-5">
    📦 My Orders
</h2>
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{-- Page Title --}}
        <div class="bg-transparent shadow rounded-lg p-6 hover:bg-slate-400 transition">
            <h3 class="text-xl font-semibold text-gray-900">
                Order History
            </h3>
            <p class="text-gray-900 mt-1">
                Review all your previous purchases.
            </p>
        </div>

        {{-- Orders Table --}}
        <div class="backdrop-blur-2xl shadow rounded-lg overflow-hidden">
            @if($orders->count())
            <table class="min-w-full divide-y divide-gray-200">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                    Order #
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                    Date
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                    Total
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                    Status
                </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-slate-400 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-green-600">
                            ${{ number_format($order->total_price, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $order->status === 'completed' 
                                            ? 'bg-green-100 text-green-700' 
                                            : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            {{-- Empty State --}}
            <div class="p-10 text-center">
                <p class="text-gray-600">
                    You have not placed any orders yet.
                </p>
                <a href="{{ route('shop.products') }}"
                    class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500 transition">
                    🛍 Start Shopping
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection