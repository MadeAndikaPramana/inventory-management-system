@extends('layouts.app')

@section('title', 'Warehouse - Current Stock')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Warehouse Stock</h2>
            <p class="text-sm text-gray-600 mt-1">Current inventory levels</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('warehouse.low-stock') }}" class="btn btn-warning">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Low Stock
            </a>
            <a href="{{ route('warehouse.adjust-stock') }}" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                Adjust Stock
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('warehouse.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" name="search" placeholder="Search items..." class="form-input" value="{{ request('search') }}">
                </div>
                <div>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="btn btn-primary flex-1">Filter</button>
                    <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="card">
        <div class="card-body p-0">
            @if($stocks->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Item Code</th>
                                <th class="table-header-cell">Item Name</th>
                                <th class="table-header-cell">Category</th>
                                <th class="table-header-cell">Current Stock</th>
                                <th class="table-header-cell">Min Stock</th>
                                <th class="table-header-cell">Unit</th>
                                <th class="table-header-cell">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($stocks as $stock)
                            @php
                                $currentQty = $stock->current_stock;
                                $minQty = $stock->itemType->min_stock;
                                $isLowStock = $currentQty <= $minQty;
                                $isOutOfStock = $currentQty == 0;
                            @endphp
                            <tr class="{{ $isOutOfStock ? 'bg-red-50' : ($isLowStock ? 'bg-yellow-50' : '') }}">
                                <td class="table-cell">
                                    <span class="font-mono text-sm font-semibold">{{ $stock->itemType->code }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="font-medium">{{ $stock->itemType->name }}</span>
                                </td>
                                <td class="table-cell text-gray-600">
                                    {{ $stock->itemType->category->name }}
                                </td>
                                <td class="table-cell">
                                    <span class="text-lg font-bold {{ $isOutOfStock ? 'text-red-600' : ($isLowStock ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ $currentQty }}
                                    </span>
                                </td>
                                <td class="table-cell text-gray-500">
                                    {{ $minQty }}
                                </td>
                                <td class="table-cell text-gray-500">
                                    {{ $stock->itemType->unit }}
                                </td>
                                <td class="table-cell">
                                    @if($isOutOfStock)
                                        <span class="badge badge-danger">Out of Stock</span>
                                    @elseif($isLowStock)
                                        <span class="badge badge-warning">Low Stock</span>
                                    @else
                                        <span class="badge badge-success">Normal</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($stocks->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $stocks->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <p class="text-gray-600">No stock records found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
