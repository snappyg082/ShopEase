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
    <h1 class="text-2xl font-bold text-gray-900">📤 Sent</h1>

    @if($sms->isEmpty())
    <div class="bg-white shadow rounded-xl p-10 text-center">
        <p class="text-gray-600 text-lg">No sent messages.</p>
    </div>
    @else
    @include('sms.partials.sms_table', ['messages' => $sms, 'type' => 'sent'])
    @endif
</div>
@endsection