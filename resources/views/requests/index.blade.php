@extends('layouts.app')

@section('title', 'Requests')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Item Requests</h2>
            <p class="text-sm text-gray-600 mt-1">Manage inventory requests</p>
        </div>
        <a href="{{ route('requests.create') }}" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            New Request
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-600">Total Requests</p>
                <p class="text-2xl font-bold text-gray-900">{{ $requests->total() }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount ?? 0 }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-gray-600">Completed</p>
                <p class="text-2xl font-bold text-green-600">{{ $completedCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card">
        <div class="card-body p-0">
            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Request #</th>
                                <th class="table-header-cell">Requestor</th>
                                <th class="table-header-cell">Department</th>
                                <th class="table-header-cell">Items</th>
                                <th class="table-header-cell">Status</th>
                                <th class="table-header-cell">Date</th>
                                <th class="table-header-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($requests as $request)
                            <tr>
                                <td class="table-cell">
                                    <span class="font-mono font-semibold text-blue-600">{{ $request->request_number }}</span>
                                </td>
                                <td class="table-cell">{{ $request->requestor_name }}</td>
                                <td class="table-cell text-gray-600">{{ $request->department }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-info">{{ $request->requestItems->count() }} items</span>
                                </td>
                                <td class="table-cell">
                                    @if($request->status === 'draft')
                                        <span class="badge badge-secondary">Draft</span>
                                    @elseif($request->status === 'submitted')
                                        <span class="badge badge-warning">Submitted</span>
                                    @else
                                        <span class="badge badge-success">Completed</span>
                                    @endif
                                </td>
                                <td class="table-cell text-gray-500">
                                    {{ $request->request_date->format('M j, Y') }}
                                </td>
                                <td class="table-cell">
                                    <a href="{{ route('requests.show', $request) }}" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $requests->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">No requests found</p>
                    <a href="{{ route('requests.create') }}" class="btn btn-primary mt-4">Create Your First Request</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
