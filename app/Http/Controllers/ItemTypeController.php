<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use App\Models\Category;
use App\Models\InventoryStock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ItemTypeController extends Controller
{
    public function index()
    {
        $query = ItemType::with(['category', 'inventoryStock']);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        if (request('status')) {
            $query->where('is_active', request('status') === 'active');
        }

        $itemTypes = $query->orderBy('name')->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('item-types.index', compact('itemTypes', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $units = ['Pcs', 'Unit', 'Rim', 'Box', 'Pack', 'Set', 'Roll', 'Liter', 'Kg'];

        return view('item-types.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:item_types',
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|in:Pcs,Unit,Rim,Box,Pack,Set,Roll,Liter,Kg',
            'min_stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'initial_stock' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $initialStock = $validated['initial_stock'] ?? 0;
            unset($validated['initial_stock']);

            $itemType = ItemType::create($validated);

            InventoryStock::create([
                'item_type_id' => $itemType->id,
                'current_stock' => $initialStock,
            ]);
        });

        return redirect()->route('item-types.index')
            ->with('success', 'Item type created successfully.');
    }

    public function show(ItemType $itemType)
    {
        $itemType->load(['category', 'inventoryStock', 'stockMovements.user']);

        return view('item-types.show', compact('itemType'));
    }

    public function edit(ItemType $itemType)
    {
        $categories = Category::orderBy('name')->get();
        $units = ['Pcs', 'Unit', 'Rim', 'Box', 'Pack', 'Set', 'Roll', 'Liter', 'Kg'];

        return view('item-types.edit', compact('itemType', 'categories', 'units'));
    }

    public function update(Request $request, ItemType $itemType)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('item_types')->ignore($itemType)],
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'unit' => 'required|in:Pcs,Unit,Rim,Box,Pack,Set,Roll,Liter,Kg',
            'min_stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $itemType->update($validated);

        return redirect()->route('item-types.index')
            ->with('success', 'Item type updated successfully.');
    }

    public function destroy(ItemType $itemType)
    {
        if ($itemType->requestItems()->exists() || $itemType->stockMovements()->exists()) {
            return redirect()->route('item-types.index')
                ->with('error', 'Cannot delete item type that has associated records.');
        }

        $itemType->inventoryStock()->delete();
        $itemType->delete();

        return redirect()->route('item-types.index')
            ->with('success', 'Item type deleted successfully.');
    }

    public function checkStock(Request $request)
    {
        $itemTypeId = $request->get('item_type_id');
        $requestedQty = $request->get('qty', 0);

        $itemType = ItemType::with('inventoryStock')->find($itemTypeId);

        if (!$itemType) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $currentStock = $itemType->inventoryStock ? $itemType->inventoryStock->current_stock : 0;
        $status = 'unavailable';
        $message = 'Out of stock';

        if ($currentStock >= $requestedQty) {
            $status = 'available';
            $message = 'Available';
        } elseif ($currentStock > 0) {
            $status = 'partial';
            $message = "Only {$currentStock} available";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'current_stock' => $currentStock,
            'requested_qty' => $requestedQty,
            'item_name' => $itemType->name,
            'unit' => $itemType->unit,
        ]);
    }
}