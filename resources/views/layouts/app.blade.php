<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Inventory Management System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="sidebar-container fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0 z-30" x-data="{ open: false }" :class="{ 'translate-x-0': open }">
            <div class="flex items-center justify-center h-16 bg-blue-600">
                <h1 class="text-white text-xl font-bold">IMS</h1>
            </div>

            <nav class="mt-5 px-2">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Dashboard
                </a>

                <div class="mt-2">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Inventory</p>

                    <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7v8a2 2 0 01-2 2m-1-10V6a2 2 0 00-2-2H5a2 2 0 00-2 2v7h3m8 0v3a2 2 0 01-2 2H9a2 2 0 01-2-2v-3m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8.01"></path>
                        </svg>
                        Categories
                    </a>

                    <a href="{{ route('item-types.index') }}" class="sidebar-link {{ request()->routeIs('item-types.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Item Types
                    </a>

                    <a href="{{ route('warehouse.index') }}" class="sidebar-link {{ request()->routeIs('warehouse.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        Warehouse
                    </a>
                </div>

                <div class="mt-4">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Operations</p>

                    <a href="{{ route('requests.index') }}" class="sidebar-link {{ request()->routeIs('requests.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Requests
                    </a>

                    <a href="{{ route('stock-movements.index') }}" class="sidebar-link {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Stock Movements
                    </a>
                </div>

                <div class="mt-4">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Procurement</p>

                    <a href="{{ route('procurement.vendors') }}" class="sidebar-link {{ request()->routeIs('procurement.vendors*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Vendors
                    </a>

                    <a href="{{ route('procurement.purchase-orders') }}" class="sidebar-link {{ request()->routeIs('procurement.purchase-orders*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v2a4 4 0 008 0v-2m-8 0h8m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"></path>
                        </svg>
                        Purchase Orders
                    </a>
                </div>

                <div class="mt-4">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Documents</p>

                    <a href="{{ route('documents.index') }}" class="sidebar-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Documents
                    </a>
                </div>
            </nav>
        </div>

        <!-- Mobile menu overlay -->
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden" x-show="open" @click="open = false" x-cloak></div>

        <!-- Main content -->
        <div class="main-content flex-1 lg:ml-0">
            <!-- Top header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center">
                            <button @click="open = !open" class="text-gray-500 focus:outline-none focus:text-gray-700 lg:hidden">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h1 class="text-2xl font-semibold text-gray-900 ml-4 lg:ml-0">
                                @yield('title', 'Dashboard')
                            </h1>
                        </div>

                        <div class="flex items-center space-x-4">
                            @if(session('success'))
                                <div class="alert alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="text-sm font-medium text-gray-700">
                                Inventory Management System
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>