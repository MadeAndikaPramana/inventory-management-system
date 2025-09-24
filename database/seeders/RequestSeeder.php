<?php

namespace Database\Seeders;

use App\Models\Request as RequestModel;
use App\Models\RequestItem;
use App\Models\ItemType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $itemTypes = ItemType::all();

        $departments = ['IT', 'HR', 'Finance', 'Operations', 'Marketing', 'Admin'];
        $requestorNames = [
            'John Doe', 'Jane Smith', 'Ahmad Rahman', 'Siti Aminah',
            'Budi Santoso', 'Dewi Kartika', 'Hendra Wijaya', 'Rina Sari'
        ];

        // Create sample requests
        for ($i = 1; $i <= 15; $i++) {
            $user = $users->random();
            $date = Carbon::now()->subDays(rand(1, 30));
            $requestNumber = 'REQ-' . $date->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $status = ['draft', 'submitted', 'completed'][rand(0, 2)];

            $request = RequestModel::create([
                'request_number' => $requestNumber,
                'requestor_name' => $requestorNames[array_rand($requestorNames)],
                'department' => $departments[array_rand($departments)],
                'request_date' => $date->format('Y-m-d'),
                'status' => $status,
                'notes' => rand(0, 1) ? 'Sample request for office supplies' : null,
                'created_by' => $user->id,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Add 1-5 items per request
            $numItems = rand(1, 5);
            $selectedItems = $itemTypes->random($numItems);

            foreach ($selectedItems as $itemType) {
                $qtyRequested = rand(1, 10);
                $qtyFulfilled = 0;
                $itemStatus = 'pending';

                if ($status === 'submitted' || $status === 'completed') {
                    // Randomly fulfill some items
                    $fulfillmentRate = rand(0, 100) / 100;
                    $qtyFulfilled = (int)($qtyRequested * $fulfillmentRate);

                    if ($qtyFulfilled == $qtyRequested) {
                        $itemStatus = 'fulfilled';
                    } elseif ($qtyFulfilled > 0) {
                        $itemStatus = 'partial';
                    } else {
                        $itemStatus = rand(0, 1) ? 'vendor_needed' : 'pending';
                    }
                }

                RequestItem::create([
                    'request_id' => $request->id,
                    'item_type_id' => $itemType->id,
                    'qty_requested' => $qtyRequested,
                    'qty_fulfilled' => $qtyFulfilled,
                    'status' => $itemStatus,
                    'notes' => rand(0, 1) ? 'Urgent request' : null,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}