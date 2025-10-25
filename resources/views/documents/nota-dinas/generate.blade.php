@extends('layouts.app')

@section('title', 'Generate Nota Dinas')

@section('content')
<div class="max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Generate Nota Dinas Internal</h2>
        <p class="text-sm text-gray-600 mt-1">Create an internal memo document</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('documents.nota-dinas.create') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="request_id" class="form-label">Select Request *</label>
                    <select name="request_id" id="request_id" class="form-select @error('request_id') border-red-500 @enderror" required>
                        <option value="">Select a completed request</option>
                        @foreach($requests as $request)
                            <option value="{{ $request->id }}">
                                {{ $request->request_number }} - {{ $request->requestor_name }} ({{ $request->request_date->format('M j, Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('request_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select a completed request to generate Nota Dinas</p>
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
