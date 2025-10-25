@extends('layouts.app')

@section('title', 'Generate BAPBJ')

@section('content')
<div class="max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Generate BAPBJ</h2>
        <p class="text-sm text-gray-600 mt-1">Create Berita Acara Penerimaan Barang/Jasa document</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('documents.bapbj.create') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="purchase_order_id" class="form-label">Select Purchase Order *</label>
                    <select name="purchase_order_id" id="purchase_order_id" class="form-select @error('purchase_order_id') border-red-500 @enderror" required>
                        <option value="">Select a completed purchase order</option>
                        @foreach($purchaseOrders as $po)
                            <option value="{{ $po->id }}">
                                {{ $po->po_number }} - {{ $po->vendor->name }} ({{ $po->po_date->format('M j, Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('purchase_order_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select a completed PO to generate BAPBJ</p>
                </div>

                <div class="form-group">
                    <label for="received_by" class="form-label">Received By *</label>
                    <input type="text" name="received_by" id="received_by" class="form-input" value="{{ old('received_by') }}" required>
                </div>

                <div class="form-group">
                    <label for="received_date" class="form-label">Received Date *</label>
                    <input type="date" name="received_date" id="received_date" class="form-input" value="{{ old('received_date', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label for="condition_notes" class="form-label">Condition Notes (Optional)</label>
                    <textarea name="condition_notes" id="condition_notes" rows="3" class="form-textarea" placeholder="Notes about the condition of received goods">{{ old('condition_notes') }}</textarea>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generate PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
