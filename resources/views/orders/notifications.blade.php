@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-400 tracking-wide">
                Tracking no.{{ $order->id }}-({{ $order->user->name }})
            </h1>

            <a href="{{ route('orders.index') }}"
                class="text-black">
                ← Back to Orders
            </a>
        </div>

        {{-- Order Summary --}}
        <div class="backdrop-blur-3xl shadow rounded-xl p-6">
            <p class="text-red-600"><strong class="text-red-700">Status:</strong> {{ ucfirst($order->status) }}</p>
            <p class="text-green-700"><strong class="text-green-600">Total:</strong> ${{ number_format($order->total_price, 2) }}</p>
            <p class="text-slate-400"><strong class="text-blue-800">Placed:</strong> {{ $order->created_at->format('M d, Y · h:i A') }}</p>
            <p class="text-slate-400"><strong class="text-gray-300">Item name:</strong> {{ $order->product->name }}</p>
        </div>

        {{-- Notifications --}}
        <div class="backdrop-blur-3xl shadow rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="backdrop-blur-3xl text-gray-400">
                    <tr>
                        <th class="px-6 py-4 text-left">Type</th>
                        <th class="px-6 py-4 text-left">Recipient</th>
                        <th class="px-6 py-4 text-left">Message</th>
                        <th class="px-6 py-4 text-left">Sent At</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($order->notifications as $notification)
                    <tr>
                        <td class="px-6 py-4 font-semibold">
                            @if($notification->type === 'email')
                            📧 Email
                            @else
                            📱 SMS
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            {{ $notification->recipient }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $notification->message }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $notification->created_at->format('M d, Y · h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                            No notifications sent for this order.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection