<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcurementController extends Controller
{
    public function vendors()
    {
        $query = Vendor::query();

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        if (request('status')) {
            $query->where('is_active', request('status') === 'active');
        }

        $vendors = $query->orderBy('name')->paginate(15);

        return view('procurement.vendors.index', compact('vendors'));
    }

    public function createVendor()
    {
        return view('procurement.vendors.create');
    }

    public function storeVendor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_person' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'is_active' => 'boolean',
        ]);

        Vendor::create($validated);

        return redirect()->route('procurement.vendors')
            ->with('success', 'Vendor created successfully.');
    }

    public function showVendor(Vendor $vendor)
    {
        $vendor->load(['purchaseOrders' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        return view('procurement.vendors.show', compact('vendor'));
    }

    public function editVendor(Vendor $vendor)
    {
        return view('procurement.vendors.edit', compact('vendor'));
    }

    public function updateVendor(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_person' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $vendor->update($validated);

        return redirect()->route('procurement.vendors')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroyVendor(Vendor $vendor)
    {
        if ($vendor->purchaseOrders()->exists()) {
            return redirect()->route('procurement.vendors')
                ->with('error', 'Cannot delete vendor that has associated purchase orders.');
        }

        $vendor->delete();

        return redirect()->route('procurement.vendors')
            ->with('success', 'Vendor deleted successfully.');
    }

    // Purchase Orders
    public function purchaseOrders()
    {
        $query = PurchaseOrder::with(['vendor', 'user', 'purchaseOrderItems']);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                      $vendorQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('vendor_id')) {
            $query->where('vendor_id', request('vendor_id'));
        }

        $purchaseOrders = $query->orderBy('created_at', 'desc')->paginate(15);
        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();

        return view('procurement.purchase-orders.index', compact('purchaseOrders', 'vendors'));
    }

    public function createPurchaseOrder()
    {
        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();
        $itemTypes = ItemType::where('is_active', true)->orderBy('name')->get();

        return view('procurement.purchase-orders.create', compact('vendors', 'itemTypes'));
    }

    public function storePurchaseOrder(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'po_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_type_id' => 'required|exists:item_types,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $poNumber = $this->generatePONumber();

            $purchaseOrderData = array_merge($validated, [
                'po_number' => $poNumber,
                'created_by' => 1,
                'status' => 'draft',
            ]);

            $items = $purchaseOrderData['items'];
            unset($purchaseOrderData['items']);

            $purchaseOrder = PurchaseOrder::create($purchaseOrderData);

            foreach ($items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_type_id' => $item['item_type_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('procurement.purchase-orders')
            ->with('success', 'Purchase order created successfully.');
    }

    public function showPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['vendor', 'user', 'purchaseOrderItems.itemType']);

        return view('procurement.purchase-orders.show', compact('purchaseOrder'));
    }

    public function editPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->route('procurement.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only draft purchase orders can be edited.');
        }

        $vendors = Vendor::where('is_active', true)->orderBy('name')->get();
        $itemTypes = ItemType::where('is_active', true)->orderBy('name')->get();
        $purchaseOrder->load('purchaseOrderItems.itemType');

        return view('procurement.purchase-orders.edit', compact('purchaseOrder', 'vendors', 'itemTypes'));
    }

    public function updatePurchaseOrder(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->route('procurement.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only draft purchase orders can be updated.');
        }

        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'po_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_type_id' => 'required|exists:item_types,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $purchaseOrder) {
            $purchaseOrderData = $validated;
            $items = $purchaseOrderData['items'];
            unset($purchaseOrderData['items']);

            $purchaseOrder->update($purchaseOrderData);
            $purchaseOrder->purchaseOrderItems()->delete();

            foreach ($items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_type_id' => $item['item_type_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('procurement.purchase-orders')
            ->with('success', 'Purchase order updated successfully.');
    }

    public function sendPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->route('procurement.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only draft purchase orders can be sent.');
        }

        $purchaseOrder->update(['status' => 'sent']);

        return redirect()->route('procurement.purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order sent successfully.');
    }

    public function completePurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'sent') {
            return redirect()->route('procurement.purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only sent purchase orders can be completed.');
        }

        $purchaseOrder->update(['status' => 'completed']);

        return redirect()->route('procurement.purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order completed successfully.');
    }

    public function destroyPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return redirect()->route('procurement.purchase-orders')
                ->with('error', 'Only draft purchase orders can be deleted.');
        }

        $purchaseOrder->delete();

        return redirect()->route('procurement.purchase-orders')
            ->with('success', 'Purchase order deleted successfully.');
    }

    private function generatePONumber()
    {
        $date = Carbon::now()->format('Ymd');
        $sequence = PurchaseOrder::whereDate('created_at', Carbon::today())->count() + 1;
        return 'PO-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}