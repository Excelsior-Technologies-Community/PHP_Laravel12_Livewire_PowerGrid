<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PowerGrid Demo</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ asset(path: 'css/custom.css') }}">

    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- PowerGrid Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/powergrid/powergrid.css') }}">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">PowerGrid Demo</h1>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        {{ $slot }}
    </main>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- PowerGrid Scripts -->
    <script src="{{ asset('vendor/powergrid/powergrid.js') }}"></script>
</body>
</html>