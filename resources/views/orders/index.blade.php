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
            <h1 class="text-2xl font-bold  text-gray-900 ">
                📦 Your Orders
            </h1>
        </div>

        {{-- Empty State --}}
        @if($orders->isEmpty())
        <div class="bg-transparent shadow rounded-xl p-10 text-center">
            <p class="text-gray-600 text-lg">
                You haven't placed any orders yet.
            </p>
            <a href="{{ route('shop.products') }}"
                class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition">
                🛍 Start Shopping
            </a>
        </div>
        @else

        {{-- Orders Table --}}
        <div class="backdrop-blur-3xl shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">

                {{-- Table Header --}}
                <thead class="backdrop-blur-3xl">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            Order ID
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            Total Price
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            Placed On
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                            Actions
                        </th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-slate-400 transition">

                        <td class="px-6 py-4 font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-green-800">
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

                        <td class="px-6 py-4 text-gray-600">
                            {{ $order->created_at->format('M d, Y · h:i A') }}
                        </td>

                        {{-- ✅ Actions column --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('orders.notifications', $order->id) }}"
                                class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold
                              text-indigo-600 hover:text-green-600
                             ">
                                View Notifications
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
    @endif

</div>
</div>
@endsection