<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>PowerGrid Product Management</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles

    <link
        rel="stylesheet"
        href="{{ asset('vendor/powergrid/powergrid.css') }}"
    >

</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow mb-8">

        <div class="max-w-7xl mx-auto px-4">

            <div class="flex items-center h-16">

                <h1 class="text-xl font-semibold text-gray-800">
                    PowerGrid Product Management
                </h1>

            </div>

        </div>

    </nav>

    <main class="max-w-7xl mx-auto px-4">

        <div class="py-6">

            <div class="mb-6">

                <h2 class="text-2xl font-bold text-gray-800">
                    Products
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Manage products using Livewire PowerGrid.
                </p>

            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">

                <div class="p-6">

                    @livewire('product-table')

                </div>

            </div>

        </div>

    </main>

    @livewireScripts

    <script src="{{ asset('vendor/powergrid/powergrid.js') }}"></script>

    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('toast', (event) => {

                alert(
                    event.message ??
                    'Operation completed successfully.'
                );

            });

        });
    </script>

</body>

</html>