@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Items</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalItems) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Stock</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalStock) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($lowStockItems) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($pendingRequests) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('requests.create') }}" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Request
                </a>
                <a href="{{ route('warehouse.adjust-stock') }}" class="btn btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Adjust Stock
                </a>
                <a href="{{ route('item-types.create') }}" class="btn btn-success">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Add Item Type
                </a>
                <a href="{{ route('documents.index') }}" class="btn btn-warning">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generate Document
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Requests -->
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Recent Requests</h3>
                    <a href="{{ route('requests.index') }}" class="text-sm text-blue-600 hover:text-blue-500">View all</a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($recentRequests->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead class="table-header">
                                <tr>
                                    <th class="table-header-cell">Request #</th>
                                    <th class="table-header-cell">Requestor</th>
                                    <th class="table-header-cell">Status</th>
                                    <th class="table-header-cell">Date</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach($recentRequests as $request)
                                <tr>
                                    <td class="table-cell">
                                        <a href="{{ route('requests.show', $request) }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $request->request_number }}
                                        </a>
                                    </td>
                                    <td class="table-cell">{{ $request->requestor_name }}</td>
                                    <td class="table-cell">
                                        <span class="badge badge-{{ $request->status === 'completed' ? 'success' : ($request->status === 'submitted' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="table-cell">{{ $request->request_date->format('M j, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        No requests found
                    </div>
                @endif
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Low Stock Alert</h3>
                    <a href="{{ route('warehouse.low-stock') }}" class="text-sm text-red-600 hover:text-red-500">View all</a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($lowStockItemsList->count() > 0)
                    <div class="space-y-3 p-6">
                        @foreach($lowStockItemsList as $item)
                        <div class="flex items-center justify-between p-3 bg-red-50 border border-red-200 rounded-md">
                            <div>
                                <p class="font-medium text-red-800">{{ $item->name }}</p>
                                <p class="text-sm text-red-600">{{ $item->category->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-red-800">
                                    {{ $item->inventoryStock->current_stock ?? 0 }} {{ $item->unit }}
                                </p>
                                <p class="text-xs text-red-600">Min: {{ $item->min_stock }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        All items are well stocked
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Stock Movements -->
    <div class="card">
        <div class="card-header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Stock Movements</h3>
                <a href="{{ route('stock-movements.index') }}" class="text-sm text-blue-600 hover:text-blue-500">View all</a>
            </div>
        </div>
        <div class="card-body p-0">
            @if($recentStockMovements->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Item</th>
                                <th class="table-header-cell">Type</th>
                                <th class="table-header-cell">Quantity</th>
                                <th class="table-header-cell">Stock After</th>
                                <th class="table-header-cell">Date</th>
                                <th class="table-header-cell">User</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($recentStockMovements as $movement)
                            <tr>
                                <td class="table-cell">
                                    <div>
                                        <p class="font-medium">{{ $movement->itemType->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $movement->itemType->code }}</p>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-{{ $movement->movement_type === 'in' ? 'success' : ($movement->movement_type === 'out' ? 'danger' : 'info') }}">
                                        {{ ucfirst($movement->movement_type) }}
                                    </span>
                                </td>
                                <td class="table-cell">{{ $movement->quantity }} {{ $movement->itemType->unit }}</td>
                                <td class="table-cell">{{ $movement->stock_after }} {{ $movement->itemType->unit }}</td>
                                <td class="table-cell">{{ $movement->created_at->format('M j, H:i') }}</td>
                                <td class="table-cell">{{ $movement->user->username }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    No stock movements found
                </div>
            @endif
        </div>
    </div>
</div>
@endsection