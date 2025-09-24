<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\ItemType;
use App\Models\Category;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $query = StockMovement::with(['itemType.category', 'user']);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('itemType', function ($itemQuery) use ($search) {
                    $itemQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('code', 'like', "%{$search}%");
                })->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if (request('movement_type')) {
            $query->where('movement_type', request('movement_type'));
        }

        if (request('item_type_id')) {
            $query->where('item_type_id', request('item_type_id'));
        }

        if (request('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }

        if (request('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }

        $movements = $query->orderBy('created_at', 'desc')->paginate(20);

        $itemTypes = ItemType::where('is_active', true)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $stats = [
            'total_in' => StockMovement::where('movement_type', 'in')->sum('quantity'),
            'total_out' => StockMovement::where('movement_type', 'out')->sum('quantity'),
            'total_adjustments' => StockMovement::where('movement_type', 'adjustment')->count(),
        ];

        return view('stock-movements.index', compact('movements', 'itemTypes', 'categories', 'stats'));
    }

    public function show(StockMovement $stockMovement)
    {
        $stockMovement->load(['itemType.category', 'user']);

        return view('stock-movements.show', compact('stockMovement'));
    }

    public function export()
    {
        $movements = StockMovement::with(['itemType.category', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'stock-movements-' . date('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($movements) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Date',
                'Item Code',
                'Item Name',
                'Category',
                'Movement Type',
                'Quantity',
                'Stock Before',
                'Stock After',
                'Reference',
                'Notes',
                'Created By',
            ]);

            foreach ($movements as $movement) {
                fputcsv($file, [
                    $movement->created_at->format('Y-m-d H:i:s'),
                    $movement->itemType->code,
                    $movement->itemType->name,
                    $movement->itemType->category->name,
                    ucfirst($movement->movement_type),
                    $movement->quantity,
                    $movement->stock_before,
                    $movement->stock_after,
                    $movement->reference,
                    $movement->notes,
                    $movement->user->username,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}