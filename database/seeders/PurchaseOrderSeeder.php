<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Vendor;
use App\Models\ItemType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $vendors = Vendor::all();
        $itemTypes = ItemType::all();

        // Create sample purchase orders
        for ($i = 1; $i <= 10; $i++) {
            $user = $users->random();
            $vendor = $vendors->random();
            $date = Carbon::now()->subDays(rand(1, 30));
            $poNumber = 'PO-' . $date->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $status = ['draft', 'sent', 'completed'][rand(0, 2)];

            $purchaseOrder = PurchaseOrder::create([
                'po_number' => $poNumber,
                'vendor_id' => $vendor->id,
                'po_date' => $date->format('Y-m-d'),
                'status' => $status,
                'notes' => rand(0, 1) ? 'Standard procurement order' : null,
                'created_by' => $user->id,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Add 1-8 items per purchase order
            $numItems = rand(1, 8);
            $selectedItems = $itemTypes->random($numItems);

            foreach ($selectedItems as $itemType) {
                $quantity = rand(5, 50);

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_type_id' => $itemType->id,
                    'quantity' => $quantity,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}