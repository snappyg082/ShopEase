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
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-400">
            {{ ucfirst($type) }}
        </h1>
        <div class="space-x-6 backdrop-blur-lg rounded-lg p-2 ">
            <a href="{{ route('sms.index', ['type' => 'inbox']) }}" class="{{ $type === 'inbox' ? 'font-bold text-indigo-600 ' : 'text-gray-700' }}">Inbox</a> |
            <a href="{{ route('sms.index', ['type' => 'sent']) }}" class="{{ $type === 'sent' ? 'font-bold text-indigo-600' : 'text-gray-700' }}">Sent</a> |
            <a href="{{ route('sms.index', ['type' => 'drafts']) }}" class="{{ $type === 'drafts' ? 'font-bold text-indigo-600' : 'text-gray-700' }}">Drafts</a> |
            <a href="{{ route('sms.index', ['type' => 'spam']) }}" class="{{ $type === 'spam' ? 'font-bold text-indigo-600' : 'text-gray-700' }}">Spam</a> |
        </div>
    </div>

    {{-- Empty State --}}
    @if($sms->isEmpty())
    <div class="backdrop-blur-xl shadow rounded-xl p-10 text-center">
        <p class="text-gray-600 text-lg">
            No messages in {{ $type }}.
        </p>
    </div>
    @else
    {{-- Messages Table --}}
    <div class="backdrop-blur-3xl shadow rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="backdrop-blur-3xl">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-200">Subject</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-200">Date</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-200">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-200">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($sms as $s)
                <tr class="hover:bg-blue-950 transition">
                    <td class="px-6 py-4 font-medium text-gray-100">
                        {{ $s->subject }}
                    </td>
                    <td class="px-6 py-4 text-gray-400">
                        {{ $s->created_at->format('Y M, d · h:i A') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($s->read)
                        <span class="text-green-600 font-semibold">Read</span>
                        @else
                        <span class="text-yellow-600 font-semibold">Unread</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('sms.show', $s->id) }}" class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold
                                   text-indigo-500 hover:text-indigo-800">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection