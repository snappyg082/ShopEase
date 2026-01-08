<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <!-- FULL PAGE BACKGROUND -->
    <div class="min-h-screen bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/mainBackground.png') }}');">


        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">


                @yield('header')
            </div>
        </header>
        @endif

        @auth
        <form action="{{ route('global.search') }}" method="GET" class="flex gap-2 justify-center py-6">
            <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}"
                class="bg-transparent text-gray-100 border border-gray-600 px-4 py-2 rounded-lg w-full max-w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Search
            </button>
        </form>
        @endauth

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 py-6">
            @yield('content')

        </main>

    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>