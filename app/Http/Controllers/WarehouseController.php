<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use App\Models\InventoryStock;
use App\Models\StockMovement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function index()
    {
        $query = InventoryStock::with(['itemType.category']);

        if (request('search')) {
            $search = request('search');
            $query->whereHas('itemType', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if (request('category_id')) {
            $query->whereHas('itemType', function ($q) {
                $q->where('category_id', request('category_id'));
            });
        }

        if (request('stock_status') === 'low') {
            $query->whereHas('itemType', function ($q) {
                $q->whereColumn('inventory_stock.current_stock', '<=', 'item_types.min_stock');
            });
        }

        $stocks = $query->orderBy('current_stock', 'asc')->paginate(20);
        $categories = Category::orderBy('name')->get();

        $lowStockCount = InventoryStock::whereHas('itemType', function ($q) {
            $q->whereColumn('inventory_stock.current_stock', '<=', 'item_types.min_stock');
        })->count();

        return view('warehouse.index', compact('stocks', 'categories', 'lowStockCount'));
    }

    public function adjustStock()
    {
        $itemTypes = ItemType::with('inventoryStock')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('warehouse.adjust-stock', compact('itemTypes'));
    }

    public function updateStock(Request $request)
    {
        $validated = $request->validate([
            'item_type_id' => 'required|exists:item_types,id',
            'adjustment_type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            $itemType = ItemType::with('inventoryStock')->findOrFail($validated['item_type_id']);
            $inventoryStock = $itemType->inventoryStock;
            $currentStock = $inventoryStock ? $inventoryStock->current_stock : 0;

            $adjustmentType = $validated['adjustment_type'];
            $quantity = $validated['quantity'];

            switch ($adjustmentType) {
                case 'in':
                    $newStock = $currentStock + $quantity;
                    break;
                case 'out':
                    $newStock = max(0, $currentStock - $quantity);
                    break;
                case 'adjustment':
                    $newStock = $quantity;
                    $quantity = $newStock - $currentStock;
                    break;
            }

            if ($inventoryStock) {
                $inventoryStock->update(['current_stock' => $newStock]);
            } else {
                InventoryStock::create([
                    'item_type_id' => $itemType->id,
                    'current_stock' => $newStock,
                ]);
            }

            StockMovement::create([
                'item_type_id' => $itemType->id,
                'movement_type' => $adjustmentType,
                'quantity' => abs($quantity),
                'stock_before' => $currentStock,
                'stock_after' => $newStock,
                'reference' => 'Manual Adjustment',
                'notes' => $validated['notes'] ?? "Manual stock {$adjustmentType}",
                'created_by' => 1,
            ]);
        });

        return redirect()->route('warehouse.index')
            ->with('success', 'Stock updated successfully.');
    }

    public function movements()
    {
        $query = StockMovement::with(['itemType.category', 'user']);

        if (request('search')) {
            $search = request('search');
            $query->whereHas('itemType', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if (request('movement_type')) {
            $query->where('movement_type', request('movement_type'));
        }

        if (request('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }

        if (request('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }

        $movements = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('warehouse.movements', compact('movements'));
    }

    public function lowStock()
    {
        $lowStockItems = ItemType::whereHas('inventoryStock', function ($query) {
            $query->whereColumn('current_stock', '<=', 'item_types.min_stock');
        })->with(['inventoryStock', 'category'])
            ->orderBy('name')
            ->paginate(20);

        return view('warehouse.low-stock', compact('lowStockItems'));
    }

    public function export()
    {
        // This would integrate with maatwebsite/excel
        // For now, return a simple CSV response
        $stocks = InventoryStock::with(['itemType.category'])->get();

        $filename = 'stock-report-' . date('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($stocks) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Item Code',
                'Item Name',
                'Category',
                'Unit',
                'Current Stock',
                'Min Stock',
                'Status',
                'Last Updated'
            ]);

            foreach ($stocks as $stock) {
                $itemType = $stock->itemType;
                $status = $stock->current_stock <= $itemType->min_stock ? 'Low Stock' : 'Normal';

                fputcsv($file, [
                    $itemType->code,
                    $itemType->name,
                    $itemType->category->name,
                    $itemType->unit,
                    $stock->current_stock,
                    $itemType->min_stock,
                    $status,
                    $stock->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}