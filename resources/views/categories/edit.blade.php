@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Category</h2>
        <p class="text-sm text-gray-600 mt-1">Update category information</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="code" class="form-label">Category Code *</label>
                    <input type="text"
                           name="code"
                           id="code"
                           class="form-input @error('code') border-red-500 @enderror"
                           value="{{ old('code', $category->code) }}"
                           required>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Category Name *</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-input @error('name') border-red-500 @enderror"
                           value="{{ old('name', $category->name) }}"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
