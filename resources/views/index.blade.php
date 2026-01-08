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
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 bg-gray-800 p-10 rounded-lg text-center w-1/2 mx-auto">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">
                <li class="inline-grid items-center px-1 pt-1 border-b-2 border-transparent text-gray-100 hover:text-blue-600 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-indigo-700 transition duration-150 ease-in-out">
                    <a href="{{ route('index') }}">ShopEaseAI</a>
                </li>
            </h2>
        </div>
    </div>
</div>
@endsection