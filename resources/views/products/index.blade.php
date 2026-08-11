<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">

    <title>PowerGrid Product Management</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Livewire --}}
    @livewireStyles

    {{-- PowerGrid --}}
    <link
        rel="stylesheet"
        href="{{ asset('vendor/powergrid/powergrid.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f8fafc;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            color: #0f172a;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .hero-gradient {
            background:
                linear-gradient(135deg,
                    #111827 0%,
                    #1e293b 50%,
                    #312e81 100%);
        }

        /* =====================================================
           DASHBOARD CARDS
        ===================================================== */

        .dashboard-card {
            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 30px rgba(15, 23, 42, .08);
        }

        .stat-icon {
            width: 46px;
            height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            font-size: 20px;
        }

        /* =====================================================
           POWERGRID CONTAINER
        ===================================================== */

        .powergrid-container {
            background: white;
            border-radius: 16px;
        }

        /* =====================================================
           POWERGRID TOOLBAR
        ===================================================== */

        .powergrid-container .pg-header {
            background: #ffffff !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 18px !important;
        }

        .powergrid-container input[type="search"],
        .powergrid-container input[type="text"] {
            border-radius: 10px !important;
            border: 1px solid #dbe1ea !important;
            background: #f8fafc !important;
            min-height: 42px;
            padding: 8px 12px !important;
            outline: none !important;
        }

        .powergrid-container input:focus {
            border-color: #6366f1 !important;
            box-shadow:
                0 0 0 3px rgba(99, 102, 241, .10) !important;
        }

        /* =====================================================
           FILTER AREA
        ===================================================== */

        .powergrid-container select {
            border-radius: 9px !important;
            border: 1px solid #dbe1ea !important;
            background: white !important;
            min-height: 38px;
        }

        /* =====================================================
           TABLE
        ===================================================== */

        .powergrid-container table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        .powergrid-container thead th {
            background: #f8fafc !important;
            color: #475569 !important;

            font-size: 12px !important;
            font-weight: 700 !important;

            text-transform: uppercase;
            letter-spacing: .04em;

            border-bottom: 1px solid #e5e7eb !important;

            padding: 14px 16px !important;

            white-space: nowrap;
        }

        .powergrid-container tbody td {
            padding: 15px 16px !important;

            color: #334155 !important;

            font-size: 14px !important;

            border-bottom: 1px solid #f1f5f9 !important;

            vertical-align: middle !important;
        }

        .powergrid-container tbody tr {
            transition: background .15s ease;
        }

        .powergrid-container tbody tr:hover {
            background: #f8fafc !important;
        }

        /* =====================================================
           TABLE FOOTER
        ===================================================== */

        .powergrid-container .pg-footer {
            background: #ffffff !important;

            border-top: 1px solid #e5e7eb !important;

            padding: 16px !important;
        }

        /* =====================================================
           PAGINATION
        ===================================================== */

        .powergrid-container button {
            border-radius: 8px;
        }

        /* =====================================================
           BUTTONS
        ===================================================== */

        .modern-button {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 8px 13px;

            border-radius: 9px;

            font-size: 13px;

            font-weight: 600;

            transition: all .15s ease;
        }

        .modern-button:hover {
            transform: translateY(-1px);
        }

        /* =====================================================
           TOAST
        ===================================================== */

        .toast-container {
            position: fixed;

            top: 24px;
            right: 24px;

            z-index: 99999;

            display: flex;
            flex-direction: column;

            gap: 10px;
        }

        .toast {
            min-width: 320px;
            max-width: 430px;

            padding: 15px 18px;

            border-radius: 14px;

            color: white;

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .18);

            display: flex;

            align-items: center;

            gap: 12px;

            animation:
                toastSlide .3s ease;
        }

        .toast-success {
            background: #16a34a;
        }

        .toast-error {
            background: #dc2626;
        }

        @keyframes toastSlide {

            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }

        }

        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 768px) {

            .powergrid-container {
                overflow-x: auto;
            }

            .powergrid-container table {
                min-width: 1000px;
            }

            .toast-container {
                left: 16px;
                right: 16px;
                top: 16px;
            }

            .toast {
                min-width: 100%;
            }

        }
    </style>

</head>


<body class="min-h-screen">


    {{-- =========================================================
     HEADER
========================================================= --}}

    <header class="hero-gradient text-white shadow-xl">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                class="
                flex
                flex-col
                sm:flex-row
                sm:items-center
                sm:justify-between
                gap-5
                py-7
            ">

                <div class="flex items-center gap-4">

                    <div
                        class="
                        w-12
                        h-12
                        rounded-2xl
                        bg-white/10
                        border
                        border-white/20
                        flex
                        items-center
                        justify-center
                        text-2xl
                    ">
                        📦
                    </div>

                    <div>

                        <h1
                            class="
                            text-xl
                            sm:text-2xl
                            font-bold
                        ">
                            PowerGrid Product Management
                        </h1>

                        <p class="text-sm text-slate-300 mt-1">
                            Livewire-powered product administration dashboard
                        </p>

                    </div>

                </div>


                <div class="flex items-center gap-2">

                    <span
                        class="
                        w-2.5
                        h-2.5
                        bg-green-400
                        rounded-full
                        animate-pulse
                    "></span>

                    <span class="text-sm text-slate-200">
                        System Online
                    </span>

                </div>

            </div>

        </div>

    </header>


    {{-- =========================================================
     MAIN
========================================================= --}}

    <main
        class="
        max-w-7xl
        mx-auto
        px-4
        sm:px-6
        lg:px-8
        py-8
    ">


        {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

        <div class="mb-8">

            <div
                class="
                flex
                flex-col
                lg:flex-row
                lg:items-end
                lg:justify-between
                gap-4
            ">

                <div>

                    <div
                        class="
                        flex
                        items-center
                        gap-2
                        mb-2
                    ">

                        <span
                            class="
                            text-sm
                            font-semibold
                            text-indigo-600
                        ">
                            PRODUCT MANAGEMENT
                        </span>

                        <span class="text-gray-300">
                            /
                        </span>

                        <span class="text-sm text-gray-500">
                            Dashboard
                        </span>

                    </div>


                    <h2
                        class="
                        text-3xl
                        sm:text-4xl
                        font-bold
                        text-gray-900
                    ">
                        Products
                    </h2>


                    <p class="text-gray-500 mt-2">
                        Search, filter, export and manage your product inventory.
                    </p>

                </div>


                <div
                    class="
                    flex
                    items-center
                    gap-2
                    text-sm
                    text-gray-500
                ">

                    <span
                        class="
                        w-2
                        h-2
                        rounded-full
                        bg-green-500
                    "></span>

                    Inventory updated in real-time

                </div>

            </div>

        </div>


        {{-- =====================================================
         SUMMARY
    ====================================================== --}}

        @php

        $totalProducts =
        \App\Models\Product::count();

        $totalStock =
        \App\Models\Product::sum('stock');

        $outOfStock =
        \App\Models\Product::where(
        'stock',
        0
        )->count();

        $lowStock =
        \App\Models\Product::where(
        'stock',
        '>',
        0
        )
        ->where(
        'stock',
        '<=',
            10
            )
            ->count();

            $activeProducts =
            \App\Models\Product::where(
            'is_active',
            true
            )->count();

            $inactiveProducts =
            \App\Models\Product::where(
            'is_active',
            false
            )->count();

            @endphp


            <div
                class="
            grid
            grid-cols-1
            sm:grid-cols-2
            lg:grid-cols-3
            xl:grid-cols-6
            gap-4
            mb-8
        ">


                {{-- PRODUCTS --}}

                <div
                    class="
                dashboard-card
                bg-white
                rounded-2xl
                border
                border-gray-100
                shadow-sm
                p-5
            ">

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-wider
                            text-gray-400
                        ">
                                Products
                            </p>

                            <p
                                class="
                            text-3xl
                            font-bold
                            text-gray-900
                            mt-2
                        ">
                                {{ number_format($totalProducts) }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Total products
                            </p>

                        </div>

                        <div
                            class="
                        stat-icon
                        bg-indigo-50
                        text-indigo-600
                    ">
                            📦
                        </div>

                    </div>

                </div>


                {{-- INVENTORY --}}

                <div
                    class="
                dashboard-card
                bg-white
                rounded-2xl
                border
                border-gray-100
                shadow-sm
                p-5
            ">

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-wider
                            text-gray-400
                        ">
                                Inventory
                            </p>

                            <p
                                class="
                            text-3xl
                            font-bold
                            text-blue-600
                            mt-2
                        ">
                                {{ number_format($totalStock) }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Units available
                            </p>

                        </div>

                        <div
                            class="
                        stat-icon
                        bg-blue-50
                        text-blue-600
                    ">
                            📊
                        </div>

                    </div>

                </div>


                {{-- OUT OF STOCK --}}

                <div
                    class="
                dashboard-card
                bg-white
                rounded-2xl
                border
                border-gray-100
                shadow-sm
                p-5
            ">

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-wider
                            text-gray-400
                        ">
                                Out of Stock
                            </p>

                            <p
                                class="
                            text-3xl
                            font-bold
                            text-red-600
                            mt-2
                        ">
                                {{ number_format($outOfStock) }}
                            </p>

                            <p class="text-xs text-red-500 mt-1">
                                Needs attention
                            </p>

                        </div>

                        <div
                            class="
                        stat-icon
                        bg-red-50
                        text-red-600
                    ">
                            ⚠️
                        </div>

                    </div>

                </div>


                {{-- LOW STOCK --}}

                <div
                    class="
                dashboard-card
                bg-white
                rounded-2xl
                border
                border-gray-100
                shadow-sm
                p-5
            ">

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-wider
                            text-gray-400
                        ">
                                Low Stock
                            </p>

                            <p
                                class="
                            text-3xl
                            font-bold
                            text-amber-500
                            mt-2
                        ">
                                {{ number_format($lowStock) }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                1–10 units
                            </p>

                        </div>

                        <div
                            class="
                        stat-icon
                        bg-amber-50
                        text-amber-600
                    ">
                            📉
                        </div>

                    </div>

                </div>


                {{-- ACTIVE --}}

                <div
                    class="
                dashboard-card
                bg-white
                rounded-2xl
                border
                border-gray-100
                shadow-sm
                p-5
            ">

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-wider
                            text-gray-400
                        ">
                                Active
                            </p>

                            <p
                                class="
                            text-3xl
                            font-bold
                            text-green-600
                            mt-2
                        ">
                                {{ number_format($activeProducts) }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Currently active
                            </p>

                        </div>

                        <div
                            class="
                        stat-icon
                        bg-green-50
                        text-green-600
                    ">
                            ✓
                        </div>

                    </div>

                </div>


                {{-- INACTIVE --}}

                <div
                    class="
                dashboard-card
                bg-white
                rounded-2xl
                border
                border-gray-100
                shadow-sm
                p-5
            ">

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-wider
                            text-gray-400
                        ">
                                Inactive
                            </p>

                            <p
                                class="
                            text-3xl
                            font-bold
                            text-gray-600
                            mt-2
                        ">
                                {{ number_format($inactiveProducts) }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Currently disabled
                            </p>

                        </div>

                        <div
                            class="
                        stat-icon
                        bg-gray-100
                        text-gray-600
                    ">
                            ⏸
                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
         PRODUCT INVENTORY
    ====================================================== --}}

            <section
                class="
            bg-white
            rounded-2xl
            shadow-sm
            border
            border-gray-200
            overflow-hidden
        ">


                {{-- SECTION HEADER --}}

                <div
                    class="
                px-5
                sm:px-6
                py-5
                border-b
                border-gray-200
            ">

                    <div
                        class="
                    flex
                    flex-col
                    lg:flex-row
                    lg:items-center
                    lg:justify-between
                    gap-4
                ">

                        <div>

                            <div class="flex items-center gap-3">

                                <div
                                    class="
                                w-10
                                h-10
                                rounded-xl
                                bg-indigo-50
                                text-indigo-600
                                flex
                                items-center
                                justify-center
                            ">
                                    🛒
                                </div>

                                <div>

                                    <h3
                                        class="
                                    text-lg
                                    font-bold
                                    text-gray-900
                                ">
                                        Product Inventory
                                    </h3>

                                    <p
                                        class="
                                    text-sm
                                    text-gray-500
                                ">
                                        Manage your products from one place.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div
                            class="
                        flex
                        flex-wrap
                        items-center
                        gap-2
                    ">

                            <span
                                class="
                            inline-flex
                            items-center
                            gap-2
                            px-3
                            py-2
                            rounded-lg
                            bg-green-50
                            border
                            border-green-100
                            text-xs
                            font-semibold
                            text-green-700
                        ">

                                <span
                                    class="
                                w-2
                                h-2
                                rounded-full
                                bg-green-500
                            "></span>

                                {{ number_format($activeProducts) }}
                                Active

                            </span>


                            <span
                                class="
                            inline-flex
                            items-center
                            gap-2
                            px-3
                            py-2
                            rounded-lg
                            bg-gray-50
                            border
                            border-gray-200
                            text-xs
                            font-semibold
                            text-gray-600
                        ">

                                <span
                                    class="
                                w-2
                                h-2
                                rounded-full
                                bg-gray-400
                            "></span>

                                {{ number_format($inactiveProducts) }}
                                Inactive

                            </span>

                        </div>

                    </div>

                </div>


                {{-- =================================================
             POWERGRID TABLE
        ================================================== --}}

                <div class="p-4 sm:p-6">

                    <div class="powergrid-container">

                        @livewire('product-table')

                    </div>

                </div>

            </section>


            {{-- =====================================================
         FOOTER
    ====================================================== --}}

            <div
                class="
            flex
            flex-col
            sm:flex-row
            justify-between
            items-center
            gap-3
            mt-6
            text-xs
            text-gray-400
        ">

                <p>
                    PowerGrid Product Management
                </p>

                <p>
                    Livewire • Laravel • PowerGrid
                </p>

            </div>

    </main>


    {{-- =========================================================
     LIVEWIRE
========================================================= --}}

    @livewireScripts


    <script src="{{ asset('vendor/powergrid/powergrid.js') }}"></script>


    {{-- =========================================================
     TOAST
========================================================= --}}

    <div
        id="toast-container"
        class="toast-container"></div>


    <script>
        document.addEventListener(
            'livewire:init',
            () => {

                Livewire.on(
                    'toast',
                    (event) => {

                        const container =
                            document.getElementById(
                                'toast-container'
                            );

                        if (!container) {
                            return;
                        }

                        const toast =
                            document.createElement('div');

                        const type =
                            event.type ?? 'success';

                        toast.className =
                            'toast ' +
                            (
                                type === 'error' ?
                                'toast-error' :
                                'toast-success'
                            );

                        const icon =
                            type === 'error' ?
                            '⚠️' :
                            '✓';

                        toast.innerHTML = `

                    <span class="text-xl">
                        ${icon}
                    </span>

                    <span
                        class="flex-1 text-sm font-medium"
                    >
                        ${
                            event.message ??
                            'Operation completed successfully.'
                        }
                    </span>

                    <button
                        type="button"
                        class="text-white/80 hover:text-white text-lg"
                        onclick="this.parentElement.remove()"
                    >
                        ×
                    </button>

                `;

                        container.appendChild(toast);

                        setTimeout(
                            () => {
                                toast.remove();
                            },
                            4000
                        );

                    }
                );

            }
        );
    </script>


</body>

</html>