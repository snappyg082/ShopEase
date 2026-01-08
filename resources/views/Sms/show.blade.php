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
<div class="min-h-screen bg-transparent flex items-center justify-center p-1 mb-10 scroll-m-0 ">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- Header -->
        <div class="bg-indigo-600 px-6 py-4 text-white">
            <h2 class="text-lg font-semibold">SMS Message</h2>
            <p class="text-sm opacity-80">
                {{ $sms->created_at->format('M d, Y · h:i A') }}
            </p>
        </div>

        <!-- Message Body -->
        <div class="p-6 space-y-4">
            <div class="flex {{ $sms->read ? 'justify-start' : 'justify-end' }}">
                <div class="
                    max-w-xs px-4 py-3 rounded-2xl text-sm
                    {{ $sms->read
                        ? 'bg-blue-200 text-gray-800 rounded-tl-none'
                        : 'bg-indigo-600 text-white rounded-tr-none'
                    }}">
                    {{ $sms->body }}
                </div>
            </div>

            <!-- Status -->
            <div class="text-right">
                @if($sms->read)
                <span class="inline-flex items-center text-green-600 text-xs font-medium">
                    ● Read
                </span>
                @else
                <span class="inline-flex items-center text-gray-400 text-xs font-medium">
                    ● Unread
                </span>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
            <a href="{{ route('sms.index') }}"
                class="text-sm text-gray-500 hover:text-blue-700">
                ← Back
            </a>

            <span class="text-xs text-gray-400">
                SMS ID #{{ $sms->id }}
            </span>
        </div>
    </div>
</div>
@endsection