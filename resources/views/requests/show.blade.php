@extends('layouts.app')

@section('title', 'Request Detail')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Request Detail</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $request->request_number }}</p>
        </div>
        <div class="flex space-x-2">
            @if($request->status === 'draft')
                <form action="{{ route('requests.submit', $request) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
            @endif
            <a href="{{ route('requests.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <!-- Request Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium">Request Information</h3>
            </div>
            <div class="card-body">
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Request Number</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono font-semibold">{{ $request->request_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Requestor</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $request->requestor_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $request->department }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Request Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $request->request_date->format('F j, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @if($request->status === 'draft')
                                <span class="badge badge-secondary">Draft</span>
                            @elseif($request->status === 'submitted')
                                <span class="badge badge-warning">Submitted</span>
                            @else
                                <span class="badge badge-success">Completed</span>
                            @endif
                        </dd>
                    </div>
                    @if($request->notes)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Notes</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $request->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-medium">Fulfillment Status</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Progress</span>
                            <span class="font-medium">{{ $request->requestItems->sum('qty_fulfilled') }} / {{ $request->requestItems->sum('qty_requested') }}</span>
                        </div>
                        @php
                            $total = $request->requestItems->sum('qty_requested');
                            $fulfilled = $request->requestItems->sum('qty_fulfilled');
                            $percentage = $total > 0 ? ($fulfilled / $total) * 100 : 0;
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-500">Total Items</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $request->requestItems->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Completed</p>
                            <p class="text-2xl font-bold text-green-600">{{ $percentage }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Items -->
    <div class="card">
        <div class="card-header">
            <h3 class="text-lg font-medium">Requested Items</h3>
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">Item</th>
                            <th class="table-header-cell">Qty Requested</th>
                            <th class="table-header-cell">Qty Fulfilled</th>
                            <th class="table-header-cell">Remaining</th>
                            <th class="table-header-cell">Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach($request->requestItems as $item)
                        <tr>
                            <td class="table-cell">
                                <div>
                                    <p class="font-medium">{{ $item->itemType->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->itemType->code }}</p>
                                </div>
                            </td>
                            <td class="table-cell">{{ $item->qty_requested }} {{ $item->itemType->unit }}</td>
                            <td class="table-cell">{{ $item->qty_fulfilled }} {{ $item->itemType->unit }}</td>
                            <td class="table-cell">{{ $item->qty_requested - $item->qty_fulfilled }} {{ $item->itemType->unit }}</td>
                            <td class="table-cell">
                                @if($item->status === 'fulfilled')
                                    <span class="badge badge-success">Fulfilled</span>
                                @elseif($item->status === 'partial')
                                    <span class="badge badge-warning">Partial</span>
                                @elseif($item->status === 'vendor_needed')
                                    <span class="badge badge-info">Vendor Needed</span>
                                @else
                                    <span class="badge badge-secondary">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
