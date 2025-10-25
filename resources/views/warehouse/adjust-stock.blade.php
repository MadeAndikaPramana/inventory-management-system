@extends('layouts.app')

@section('title', 'Adjust Stock')

@section('content')
<div class="max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Adjust Stock</h2>
        <p class="text-sm text-gray-600 mt-1">Manually adjust inventory stock levels</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('warehouse.update-stock') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="item_type_id" class="form-label">Item *</label>
                    <select name="item_type_id" id="item_type_id" class="form-select @error('item_type_id') border-red-500 @enderror" required>
                        <option value="">Select Item</option>
                        @foreach($itemTypes as $itemType)
                            <option value="{{ $itemType->id }}" data-current-stock="{{ $itemType->inventoryStock->current_stock ?? 0 }}" data-unit="{{ $itemType->unit }}">
                                {{ $itemType->code }} - {{ $itemType->name }} (Current: {{ $itemType->inventoryStock->current_stock ?? 0 }} {{ $itemType->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('item_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" x-data="{ currentStock: 0, unit: '' }">
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm font-medium text-blue-900">Current Stock</p>
                        <p class="text-2xl font-bold text-blue-600" x-text="currentStock + ' ' + unit">0</p>
                    </div>
                    <script>
                        document.getElementById('item_type_id').addEventListener('change', function() {
                            var selectedOption = this.options[this.selectedIndex];
                            var currentStock = selectedOption.getAttribute('data-current-stock') || 0;
                            var unit = selectedOption.getAttribute('data-unit') || '';
                            Alpine.store('stockData', { currentStock: currentStock, unit: unit });
                        });
                    </script>
                </div>

                <div class="form-group">
                    <label for="adjustment_type" class="form-label">Adjustment Type *</label>
                    <select name="adjustment_type" id="adjustment_type" class="form-select @error('adjustment_type') border-red-500 @enderror" required>
                        <option value="">Select Type</option>
                        <option value="in">Stock In (Add)</option>
                        <option value="out">Stock Out (Subtract)</option>
                        <option value="adjustment">Direct Adjustment</option>
                    </select>
                    @error('adjustment_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 text-sm text-gray-600">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Stock In:</strong> Increases stock (e.g., purchase received)</li>
                            <li><strong>Stock Out:</strong> Decreases stock (e.g., item used/issued)</li>
                            <li><strong>Direct Adjustment:</strong> Set exact stock amount</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity *</label>
                    <input type="number"
                           name="quantity"
                           id="quantity"
                           class="form-input @error('quantity') border-red-500 @enderror"
                           value="{{ old('quantity') }}"
                           min="1"
                           required>
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="reference" class="form-label">Reference (Optional)</label>
                    <input type="text"
                           name="reference"
                           id="reference"
                           class="form-input"
                           value="{{ old('reference') }}"
                           placeholder="e.g., PO-001, Request-123">
                    <p class="mt-1 text-sm text-gray-500">Document reference for this adjustment</p>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea name="notes"
                              id="notes"
                              rows="3"
                              class="form-textarea"
                              placeholder="Additional notes about this adjustment">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Apply Adjustment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
