@extends('layouts.app')

@section('title', 'Vendors')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Vendors</h2>
            <p class="text-sm text-gray-600 mt-1">Manage supplier information</p>
        </div>
    </div>

    <!-- Vendors Table -->
    <div class="card">
        <div class="card-body p-0">
            @if(isset($vendors) && $vendors->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Name</th>
                                <th class="table-header-cell">Contact Person</th>
                                <th class="table-header-cell">Phone</th>
                                <th class="table-header-cell">Address</th>
                                <th class="table-header-cell">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($vendors as $vendor)
                            <tr>
                                <td class="table-cell font-medium">{{ $vendor->name }}</td>
                                <td class="table-cell">{{ $vendor->contact_person }}</td>
                                <td class="table-cell">{{ $vendor->phone }}</td>
                                <td class="table-cell text-sm text-gray-600">{{ Str::limit($vendor->address, 50) }}</td>
                                <td class="table-cell">
                                    <span class="badge {{ $vendor->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $vendor->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($vendors->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $vendors->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <p class="text-gray-600">No vendors found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
