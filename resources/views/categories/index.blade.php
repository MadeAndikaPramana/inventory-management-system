@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Categories</h2>
            <p class="text-sm text-gray-600 mt-1">Manage inventory categories</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Category
        </a>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Code</th>
                                <th class="table-header-cell">Name</th>
                                <th class="table-header-cell">Items Count</th>
                                <th class="table-header-cell">Created</th>
                                <th class="table-header-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($categories as $category)
                            <tr>
                                <td class="table-cell">
                                    <span class="font-mono text-sm font-semibold text-blue-600">{{ $category->code }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="font-medium">{{ $category->name }}</span>
                                </td>
                                <td class="table-cell">
                                    <span class="badge badge-info">{{ $category->itemTypes->count() }} items</span>
                                </td>
                                <td class="table-cell text-gray-500">
                                    {{ $category->created_at->format('M j, Y') }}
                                </td>
                                <td class="table-cell">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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

                @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7v8a2 2 0 01-2 2m-1-10V6a2 2 0 00-2-2H5a2 2 0 00-2 2v7h3m8 0v3a2 2 0 01-2 2H9a2 2 0 01-2-2v-3m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8.01"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">No categories found</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary mt-4">Add Your First Category</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
