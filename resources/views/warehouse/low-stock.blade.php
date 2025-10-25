@extends('layouts.app')

@section('title', 'Low Stock Items')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Low Stock Alert</h2>
            <p class="text-sm text-gray-600 mt-1">Items that need restocking</p>
        </div>
        <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">
            Back to Warehouse
        </a>
    </div>

    <!-- Low Stock Items -->
    <div class="card">
        <div class="card-body p-0">
            @if($lowStockItems->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Item</th>
                                <th class="table-header-cell">Category</th>
                                <th class="table-header-cell">Current Stock</th>
                                <th class="table-header-cell">Min Stock</th>
                                <th class="table-header-cell">Needed</th>
                                <th class="table-header-cell">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($lowStockItems as $item)
                            @php
                                $currentStock = $item->inventoryStock->current_stock ?? 0;
                                $needed = $item->min_stock - $currentStock;
                                $isOutOfStock = $currentStock == 0;
                            @endphp
                            <tr class="{{ $isOutOfStock ? 'bg-red-50' : 'bg-yellow-50' }}">
                                <td class="table-cell">
                                    <div>
                                        <p class="font-medium">{{ $item->name }}</p>
                                        <p class="text-sm text-gray-500 font-mono">{{ $item->code }}</p>
                                    </div>
                                </td>
                                <td class="table-cell text-gray-600">{{ $item->category->name }}</td>
                                <td class="table-cell">
                                    <span class="text-lg font-bold {{ $isOutOfStock ? 'text-red-600' : 'text-yellow-600' }}">
                                        {{ $currentStock }} {{ $item->unit }}
                                    </span>
                                </td>
                                <td class="table-cell text-gray-500">{{ $item->min_stock }} {{ $item->unit }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-danger">{{ max(0, $needed) }} {{ $item->unit }}</span>
                                </td>
                                <td class="table-cell">
                                    @if($isOutOfStock)
                                        <span class="badge badge-danger">Out of Stock</span>
                                    @else
                                        <span class="badge badge-warning">Low Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">All items are well stocked!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
