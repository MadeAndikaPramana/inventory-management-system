@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Purchase Orders</h2>
            <p class="text-sm text-gray-600 mt-1">Manage vendor purchase orders</p>
        </div>
    </div>

    <!-- Purchase Orders Table -->
    <div class="card">
        <div class="card-body p-0">
            @if(isset($purchaseOrders) && $purchaseOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">PO Number</th>
                                <th class="table-header-cell">Vendor</th>
                                <th class="table-header-cell">PO Date</th>
                                <th class="table-header-cell">Items</th>
                                <th class="table-header-cell">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($purchaseOrders as $po)
                            <tr>
                                <td class="table-cell">
                                    <span class="font-mono font-semibold text-blue-600">{{ $po->po_number }}</span>
                                </td>
                                <td class="table-cell">{{ $po->vendor->name }}</td>
                                <td class="table-cell text-gray-500">{{ $po->po_date->format('M j, Y') }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-info">{{ $po->purchaseOrderItems->count() }} items</span>
                                </td>
                                <td class="table-cell">
                                    @if($po->status === 'draft')
                                        <span class="badge badge-secondary">Draft</span>
                                    @elseif($po->status === 'sent')
                                        <span class="badge badge-warning">Sent</span>
                                    @else
                                        <span class="badge badge-success">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($purchaseOrders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $purchaseOrders->links() }}
                </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <p class="text-gray-600">No purchase orders found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
