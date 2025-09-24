<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\RequestItem;
use App\Models\ItemType;
use App\Models\InventoryStock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function index()
    {
        $query = RequestModel::with(['user', 'requestItems.itemType']);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('requestor_name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('date_from')) {
            $query->whereDate('request_date', '>=', request('date_from'));
        }

        if (request('date_to')) {
            $query->whereDate('request_date', '<=', request('date_to'));
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        $itemTypes = ItemType::with('inventoryStock')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('requests.create', compact('itemTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'requestor_name' => 'required|string|max:100',
            'department' => 'required|string|max:50',
            'request_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_type_id' => 'required|exists:item_types,id',
            'items.*.qty_requested' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $requestNumber = $this->generateRequestNumber();

            $requestData = array_merge($validated, [
                'request_number' => $requestNumber,
                'created_by' => 1,
                'status' => 'draft',
            ]);

            $items = $requestData['items'];
            unset($requestData['items']);

            $requestModel = RequestModel::create($requestData);

            foreach ($items as $item) {
                RequestItem::create([
                    'request_id' => $requestModel->id,
                    'item_type_id' => $item['item_type_id'],
                    'qty_requested' => $item['qty_requested'],
                    'notes' => $item['notes'] ?? null,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()->route('requests.index')
            ->with('success', 'Request created successfully.');
    }

    public function show(RequestModel $request)
    {
        $request->load(['user', 'requestItems.itemType.inventoryStock']);

        return view('requests.show', compact('request'));
    }

    public function edit(RequestModel $request)
    {
        if ($request->status !== 'draft') {
            return redirect()->route('requests.show', $request)
                ->with('error', 'Only draft requests can be edited.');
        }

        $itemTypes = ItemType::with('inventoryStock')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $request->load('requestItems.itemType');

        return view('requests.edit', compact('request', 'itemTypes'));
    }

    public function update(Request $request, RequestModel $requestModel)
    {
        if ($requestModel->status !== 'draft') {
            return redirect()->route('requests.show', $requestModel)
                ->with('error', 'Only draft requests can be updated.');
        }

        $validated = $request->validate([
            'requestor_name' => 'required|string|max:100',
            'department' => 'required|string|max:50',
            'request_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_type_id' => 'required|exists:item_types,id',
            'items.*.qty_requested' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $requestModel) {
            $requestData = $validated;
            $items = $requestData['items'];
            unset($requestData['items']);

            $requestModel->update($requestData);
            $requestModel->requestItems()->delete();

            foreach ($items as $item) {
                RequestItem::create([
                    'request_id' => $requestModel->id,
                    'item_type_id' => $item['item_type_id'],
                    'qty_requested' => $item['qty_requested'],
                    'notes' => $item['notes'] ?? null,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()->route('requests.index')
            ->with('success', 'Request updated successfully.');
    }

    public function submit(RequestModel $request)
    {
        if ($request->status !== 'draft') {
            return redirect()->route('requests.show', $request)
                ->with('error', 'Only draft requests can be submitted.');
        }

        DB::transaction(function () use ($request) {
            $request->update(['status' => 'submitted']);
            $this->processRequest($request);
        });

        return redirect()->route('requests.show', $request)
            ->with('success', 'Request submitted and processed successfully.');
    }

    public function destroy(RequestModel $request)
    {
        if ($request->status !== 'draft') {
            return redirect()->route('requests.index')
                ->with('error', 'Only draft requests can be deleted.');
        }

        $request->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Request deleted successfully.');
    }

    private function generateRequestNumber()
    {
        $date = Carbon::now()->format('Ymd');
        $sequence = RequestModel::whereDate('created_at', Carbon::today())->count() + 1;
        return 'REQ-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    private function processRequest(RequestModel $request)
    {
        $request->load('requestItems.itemType.inventoryStock');

        foreach ($request->requestItems as $requestItem) {
            $itemType = $requestItem->itemType;
            $inventoryStock = $itemType->inventoryStock;
            $currentStock = $inventoryStock ? $inventoryStock->current_stock : 0;
            $requestedQty = $requestItem->qty_requested;

            if ($currentStock >= $requestedQty) {
                $fulfilledQty = $requestedQty;
                $newStatus = 'fulfilled';
            } else {
                $fulfilledQty = $currentStock;
                $newStatus = $currentStock > 0 ? 'partial' : 'vendor_needed';
            }

            $requestItem->update([
                'qty_fulfilled' => $fulfilledQty,
                'status' => $newStatus,
            ]);

            if ($fulfilledQty > 0) {
                $newStock = $currentStock - $fulfilledQty;

                if ($inventoryStock) {
                    $inventoryStock->update(['current_stock' => $newStock]);
                }

                StockMovement::create([
                    'item_type_id' => $itemType->id,
                    'movement_type' => 'out',
                    'quantity' => $fulfilledQty,
                    'stock_before' => $currentStock,
                    'stock_after' => $newStock,
                    'reference' => $request->request_number,
                    'notes' => "Request fulfillment for {$request->requestor_name}",
                    'created_by' => 1,
                ]);
            }
        }

        $allFulfilled = $request->requestItems()->where('status', '!=', 'fulfilled')->count() === 0;
        if ($allFulfilled) {
            $request->update(['status' => 'completed']);
        }
    }
}