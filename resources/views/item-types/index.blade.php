@extends('layouts.app')

@section('title', 'Item Types')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Item Types</h2>
            <p class="text-sm text-gray-600 mt-1">Manage inventory item types</p>
        </div>
        <a href="{{ route('item-types.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Item Type
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('item-types.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="search" placeholder="Search by name or code..." class="form-input" value="{{ request('search') }}">
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
                <div>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="btn btn-primary flex-1">Filter</button>
                    <a href="{{ route('item-types.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Item Types Table -->
    <div class="card">
        <div class="card-body p-0">
            @if($itemTypes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Code</th>
                                <th class="table-header-cell">Name</th>
                                <th class="table-header-cell">Category</th>
                                <th class="table-header-cell">Current Stock</th>
                                <th class="table-header-cell">Min Stock</th>
                                <th class="table-header-cell">Unit</th>
                                <th class="table-header-cell">Status</th>
                                <th class="table-header-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($itemTypes as $itemType)
                            <tr>
                                <td class="table-cell">
                                    <span class="font-mono text-sm font-semibold text-blue-600">{{ $itemType->code }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="font-medium">{{ $itemType->name }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="text-sm text-gray-600">{{ $itemType->category->name }}</span>
                                </td>
                                <td class="table-cell">
                                    @php
                                        $currentStock = $itemType->inventoryStock->current_stock ?? 0;
                                        $isLowStock = $currentStock <= $itemType->min_stock;
                                    @endphp
                                    <span class="badge {{ $isLowStock ? 'badge-danger' : 'badge-success' }}">
                                        {{ $currentStock }}
                                    </span>
                                </td>
                                <td class="table-cell text-gray-500">{{ $itemType->min_stock }}</td>
                                <td class="table-cell text-gray-500">{{ $itemType->unit }}</td>
                                <td class="table-cell">
                                    <span class="badge {{ $itemType->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $itemType->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('item-types.edit', $itemType) }}" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('item-types.destroy', $itemType) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($itemTypes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $itemTypes->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">No item types found</p>
                    <a href="{{ route('item-types.create') }}" class="btn btn-primary mt-4">Add Your First Item Type</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
