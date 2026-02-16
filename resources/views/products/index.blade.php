<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PowerGrid Demo</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
        <div class="py-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Products</h2>
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
        // Handle edit product event
        document.addEventListener('livewire:init', function () {
            Livewire.on('editProduct', (productId) => {
                alert('Edit product: ' + productId);
            });

            Livewire.on('deleteProduct', (productId) => {
                if (confirm('Are you sure you want to delete this product?')) {
                    Livewire.dispatch('deleteProduct', { productId: productId });
                }
            });
        });
    </script>
</body>
</html>