@extends('layouts.app')

@section('title', 'Stock Movements')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Stock Movements</h2>
            <p class="text-sm text-gray-600 mt-1">Audit trail of all stock changes</p>
        </div>
        <a href="{{ route('warehouse.adjust-stock') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
            Adjust Stock
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('stock-movements.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <select name="movement_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="in" {{ request('movement_type') == 'in' ? 'selected' : '' }}>Stock In</option>
                        <option value="out" {{ request('movement_type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                        <option value="adjustment" {{ request('movement_type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                    </select>
                </div>
                <div>
                    <input type="date" name="date_from" class="form-input" value="{{ request('date_from') }}" placeholder="From Date">
                </div>
                <div>
                    <input type="date" name="date_to" class="form-input" value="{{ request('date_to') }}" placeholder="To Date">
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="btn btn-primary flex-1">Filter</button>
                    <a href="{{ route('stock-movements.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Movements Table -->
    <div class="card">
        <div class="card-body p-0">
            @if($movements->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Date/Time</th>
                                <th class="table-header-cell">Item</th>
                                <th class="table-header-cell">Type</th>
                                <th class="table-header-cell">Quantity</th>
                                <th class="table-header-cell">Stock Before</th>
                                <th class="table-header-cell">Stock After</th>
                                <th class="table-header-cell">Reference</th>
                                <th class="table-header-cell">User</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($movements as $movement)
                            <tr>
                                <td class="table-cell">
                                    <div>
                                        <p class="text-sm font-medium">{{ $movement->created_at->format('M j, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $movement->created_at->format('H:i:s') }}</p>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <div>
                                        <p class="font-medium">{{ $movement->itemType->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $movement->itemType->code }}</p>
                                    </div>
                                </td>
                                <td class="table-cell">
                                    @if($movement->movement_type === 'in')
                                        <span class="badge badge-success">Stock In</span>
                                    @elseif($movement->movement_type === 'out')
                                        <span class="badge badge-danger">Stock Out</span>
                                    @else
                                        <span class="badge badge-info">Adjustment</span>
                                    @endif
                                </td>
                                <td class="table-cell font-semibold">{{ $movement->quantity }} {{ $movement->itemType->unit }}</td>
                                <td class="table-cell text-gray-600">{{ $movement->stock_before }}</td>
                                <td class="table-cell text-gray-600">{{ $movement->stock_after }}</td>
                                <td class="table-cell text-sm text-gray-500">{{ $movement->reference ?? '-' }}</td>
                                <td class="table-cell text-sm">{{ $movement->user->username }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($movements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $movements->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <p class="text-gray-600">No stock movements found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
