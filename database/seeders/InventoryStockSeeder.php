<?php

namespace Database\Seeders;

use App\Models\ItemType;
use App\Models\InventoryStock;
use Illuminate\Database\Seeder;

class InventoryStockSeeder extends Seeder
{
    public function run(): void
    {
        $itemTypes = ItemType::all();

        foreach ($itemTypes as $itemType) {
            // Generate random stock between min_stock and min_stock * 3
            // Some items will be low stock, some will be well stocked
            $multiplier = rand(1, 8) / 2; // 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4
            $currentStock = (int)($itemType->min_stock * $multiplier);

            InventoryStock::create([
                'item_type_id' => $itemType->id,
                'current_stock' => $currentStock,
            ]);
        }
    }
}