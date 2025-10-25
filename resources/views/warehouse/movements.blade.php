@extends('layouts.app')

@section('title', 'Stock Movements')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Stock Movements</h2>
            <p class="text-sm text-gray-600 mt-1">History of all stock changes</p>
        </div>
        <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">Back to Warehouse</a>
    </div>

    <!-- Movements Table -->
    <div class="card">
        <div class="card-body p-0">
            @if(isset($movements) && $movements->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Date/Time</th>
                                <th class="table-header-cell">Item</th>
                                <th class="table-header-cell">Type</th>
                                <th class="table-header-cell">Quantity</th>
                                <th class="table-header-cell">Stock After</th>
                                <th class="table-header-cell">User</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($movements as $movement)
                            <tr>
                                <td class="table-cell">
                                    <div>
                                        <p class="text-sm font-medium">{{ $movement->created_at->format('M j, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $movement->created_at->format('H:i') }}</p>
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
                                        <span class="badge badge-success">In</span>
                                    @elseif($movement->movement_type === 'out')
                                        <span class="badge badge-danger">Out</span>
                                    @else
                                        <span class="badge badge-info">Adjustment</span>
                                    @endif
                                </td>
                                <td class="table-cell font-semibold">{{ $movement->quantity }} {{ $movement->itemType->unit }}</td>
                                <td class="table-cell">{{ $movement->stock_after }} {{ $movement->itemType->unit }}</td>
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
