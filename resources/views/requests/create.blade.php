@extends('layouts.app')

@section('title', 'New Request')

@section('content')
<div class="max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Create New Request</h2>
        <p class="text-sm text-gray-600 mt-1">Submit an inventory request</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('requests.store') }}" method="POST" x-data="requestForm()">
                @csrf

                <!-- Request Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="form-group">
                        <label for="requestor_name" class="form-label">Requestor Name *</label>
                        <input type="text" name="requestor_name" id="requestor_name" class="form-input" value="{{ old('requestor_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">Department *</label>
                        <input type="text" name="department" id="department" class="form-input" value="{{ old('department') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="request_date" class="form-label">Request Date *</label>
                        <input type="date" name="request_date" id="request_date" class="form-input" value="{{ old('request_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <input type="text" name="notes" id="notes" class="form-input" value="{{ old('notes') }}">
                    </div>
                </div>

                <!-- Items Section -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Requested Items</h3>
                        <button type="button" @click="addItem()" class="btn btn-sm btn-primary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Item
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="p-4 border border-gray-200 rounded-md bg-gray-50">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                    <div class="md:col-span-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Item *</label>
                                        <select :name="'items['+index+'][item_type_id]'" class="form-select" required>
                                            <option value="">Select Item</option>
                                            @foreach($itemTypes as $itemType)
                                                <option value="{{ $itemType->id }}">
                                                    {{ $itemType->code }} - {{ $itemType->name }} (Available: {{ $itemType->inventoryStock->current_stock ?? 0 }} {{ $itemType->unit }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                        <input type="number" :name="'items['+index+'][qty_requested]'" class="form-input" min="1" required>
                                    </div>
                                    <div class="md:col-span-2 flex items-end">
                                        <button type="button" @click="removeItem(index)" class="btn btn-danger w-full">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="items.length === 0" class="p-8 text-center border-2 border-dashed border-gray-300 rounded-md">
                            <p class="text-gray-500">No items added yet. Click "Add Item" to begin.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('requests.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="status" value="draft" class="btn btn-secondary">
                        Save as Draft
                    </button>
                    <button type="submit" name="status" value="submitted" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function requestForm() {
    return {
        items: [{ item_type_id: '', qty_requested: '' }],
        addItem() {
            this.items.push({ item_type_id: '', qty_requested: '' });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            } else {
                alert('At least one item is required');
            }
        }
    }
}
</script>
@endsection
