<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use App\Models\InventoryStock;
use App\Models\Request as RequestModel;
use App\Models\StockMovement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = ItemType::where('is_active', true)->count();
        $totalStock = InventoryStock::sum('current_stock');
        $lowStockItems = ItemType::whereHas('inventoryStock', function ($query) {
            $query->whereColumn('current_stock', '<=', 'item_types.min_stock');
        })->with('inventoryStock')->count();

        $totalRequests = RequestModel::count();
        $pendingRequests = RequestModel::where('status', 'submitted')->count();
        $completedRequests = RequestModel::where('status', 'completed')->count();

        $recentRequests = RequestModel::with('user', 'requestItems.itemType')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $lowStockItemsList = ItemType::whereHas('inventoryStock', function ($query) {
            $query->whereColumn('current_stock', '<=', 'item_types.min_stock');
        })->with(['inventoryStock', 'category'])
            ->limit(10)
            ->get();

        $recentStockMovements = StockMovement::with(['itemType', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $stockByCategory = Category::withCount(['itemTypes as total_stock' => function ($query) {
            $query->join('inventory_stock', 'item_types.id', '=', 'inventory_stock.item_type_id')
                  ->select(DB::raw('SUM(inventory_stock.current_stock)'));
        }])->get();

        return view('dashboard', compact(
            'totalItems',
            'totalStock',
            'lowStockItems',
            'totalRequests',
            'pendingRequests',
            'completedRequests',
            'recentRequests',
            'lowStockItemsList',
            'recentStockMovements',
            'stockByCategory'
        ));
    }
}