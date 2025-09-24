<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            VendorSeeder::class,
            ItemTypeSeeder::class,
            InventoryStockSeeder::class,
            RequestSeeder::class,
            PurchaseOrderSeeder::class,
        ]);
    }
}
