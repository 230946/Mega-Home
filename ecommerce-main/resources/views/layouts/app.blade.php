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
    {{-- <x-banner /> --}}

    <div class="min-h-screen bg-gray-100">
        {{-- @livewire('navigation-menu') --}}

        <!-- Page Heading -->
        {{-- @if (isset($header)) --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto">
                <div class="container mx-auto flex justify-between items-center py-4 px-6">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}"
                        class="text-xl font-bold text-gray-800">{{ config('app.name') }}</a>

                    <!-- Buscador -->
                    <div class="flex items-center w-full max-w-md mx-4">
                        <form action="{{ route('dashboard') }}" class="flex">
                            <input type="text" placeholder="Buscar productos..." name="search" id="search"
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                                Buscar
                            </button>
                        </form>
                    </div>

                    <!-- Botón carrito -->
                    <a class="flex items-center text-gray-700 relative" href="{{ route('cart') }}">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-4-8H3M7 13l1 2h8l1-2M5 21h2M17 21h2" />
                        </svg>
                        <span
                            class="bg-green-500 rounded-full text-center px-2 text-xs absolute right-[42px] top-[-11px] animate-bounce">
                            {{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}
                        </span>
                        <span>Carrito</span>
                    </a>
                </div>
            </div>
        </header>
        {{-- @endif --}}

        <!-- Page Content -->
        <main>
            @if (session()->has('categories'))
                <!-- Categorías -->
                <nav class="bg-gray-50 shadow-sm">
                    <div class="container mx-auto px-6 py-3 flex gap-x-4 justify-center">
                        @foreach (session()->get('categories', []) as $category)
                            <div><a href="#" class="text-gray-600 hover:text-blue-600">{{ $category->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </nav>
            @endif
            <div class="relative">
                {{-- display message laravel flash --}}
                @if (session()->has('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 alert w-[500px] absolute right-0 z-[9999]"
                        role="alert">
                        <p class="font-bold">Acción exitosa</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.querySelector('.alert').style.display = 'none';
                        }, 3000);
                    </script>
                @endif
                @if (session()->has('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 alert w-[500px] absolute right-0 z-[9999]"
                        role="alert">
                        <p class="font-bold">Hubo un error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.querySelector('.alert').style.display = 'none';
                        }, 3000);
                    </script>
                @endif
            </div>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
