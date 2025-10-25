@extends('layouts.app')

@section('title', 'Edit Item Type')

@section('content')
<div class="max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Item Type</h2>
        <p class="text-sm text-gray-600 mt-1">Update item type information</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('item-types.update', $itemType) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="code" class="form-label">Item Code *</label>
                    <input type="text"
                           name="code"
                           id="code"
                           class="form-input @error('code') border-red-500 @enderror"
                           value="{{ old('code', $itemType->code) }}"
                           required>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Item Name *</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-input @error('name') border-red-500 @enderror"
                           value="{{ old('name', $itemType->name) }}"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id" class="form-label">Category *</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') border-red-500 @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $itemType->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit" class="form-label">Unit *</label>
                    <select name="unit" id="unit" class="form-select @error('unit') border-red-500 @enderror" required>
                        <option value="">Select Unit</option>
                        <option value="Pcs" {{ old('unit', $itemType->unit) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="Unit" {{ old('unit', $itemType->unit) == 'Unit' ? 'selected' : '' }}>Unit</option>
                        <option value="Rim" {{ old('unit', $itemType->unit) == 'Rim' ? 'selected' : '' }}>Rim</option>
                        <option value="Box" {{ old('unit', $itemType->unit) == 'Box' ? 'selected' : '' }}>Box</option>
                        <option value="Pack" {{ old('unit', $itemType->unit) == 'Pack' ? 'selected' : '' }}>Pack</option>
                        <option value="Set" {{ old('unit', $itemType->unit) == 'Set' ? 'selected' : '' }}>Set</option>
                        <option value="Roll" {{ old('unit', $itemType->unit) == 'Roll' ? 'selected' : '' }}>Roll</option>
                        <option value="Liter" {{ old('unit', $itemType->unit) == 'Liter' ? 'selected' : '' }}>Liter</option>
                        <option value="Kg" {{ old('unit', $itemType->unit) == 'Kg' ? 'selected' : '' }}>Kg</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="min_stock" class="form-label">Minimum Stock *</label>
                    <input type="number"
                           name="min_stock"
                           id="min_stock"
                           class="form-input @error('min_stock') border-red-500 @enderror"
                           value="{{ old('min_stock', $itemType->min_stock) }}"
                           min="0"
                           required>
                    @error('min_stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('is_active', $itemType->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('item-types.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Item Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
