<?php

namespace Database\Seeders;

use App\Models\ItemType;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('code');

        $itemTypes = [
            // ATK (Alat Tulis Kantor)
            ['code' => 'ATK001', 'name' => 'Pulpen Biru', 'category_id' => $categories['ATK']->id, 'unit' => 'Pcs', 'min_stock' => 10],
            ['code' => 'ATK002', 'name' => 'Pulpen Hitam', 'category_id' => $categories['ATK']->id, 'unit' => 'Pcs', 'min_stock' => 10],
            ['code' => 'ATK003', 'name' => 'Pensil 2B', 'category_id' => $categories['ATK']->id, 'unit' => 'Pcs', 'min_stock' => 15],
            ['code' => 'ATK004', 'name' => 'Penghapus', 'category_id' => $categories['ATK']->id, 'unit' => 'Pcs', 'min_stock' => 20],
            ['code' => 'ATK005', 'name' => 'Spidol Whiteboard', 'category_id' => $categories['ATK']->id, 'unit' => 'Pcs', 'min_stock' => 5],
            ['code' => 'ATK006', 'name' => 'Kertas A4 80gsm', 'category_id' => $categories['ATK']->id, 'unit' => 'Rim', 'min_stock' => 5],
            ['code' => 'ATK007', 'name' => 'Kertas A3 80gsm', 'category_id' => $categories['ATK']->id, 'unit' => 'Rim', 'min_stock' => 3],
            ['code' => 'ATK008', 'name' => 'Stapler', 'category_id' => $categories['ATK']->id, 'unit' => 'Unit', 'min_stock' => 3],
            ['code' => 'ATK009', 'name' => 'Isi Stapler', 'category_id' => $categories['ATK']->id, 'unit' => 'Box', 'min_stock' => 10],
            ['code' => 'ATK010', 'name' => 'Paper Clip', 'category_id' => $categories['ATK']->id, 'unit' => 'Box', 'min_stock' => 5],

            // Electronics
            ['code' => 'ELEC001', 'name' => 'Kalkulator Casio', 'category_id' => $categories['ELEC']->id, 'unit' => 'Unit', 'min_stock' => 2],
            ['code' => 'ELEC002', 'name' => 'Baterai AA', 'category_id' => $categories['ELEC']->id, 'unit' => 'Pack', 'min_stock' => 5],
            ['code' => 'ELEC003', 'name' => 'Baterai AAA', 'category_id' => $categories['ELEC']->id, 'unit' => 'Pack', 'min_stock' => 5],
            ['code' => 'ELEC004', 'name' => 'Lampu LED 12W', 'category_id' => $categories['ELEC']->id, 'unit' => 'Pcs', 'min_stock' => 3],
            ['code' => 'ELEC005', 'name' => 'Extension Cable 5m', 'category_id' => $categories['ELEC']->id, 'unit' => 'Unit', 'min_stock' => 2],

            // Office Furniture
            ['code' => 'FURN001', 'name' => 'Kursi Kantor', 'category_id' => $categories['FURN']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'FURN002', 'name' => 'Meja Kerja', 'category_id' => $categories['FURN']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'FURN003', 'name' => 'Lemari Filing', 'category_id' => $categories['FURN']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'FURN004', 'name' => 'Whiteboard 120x90cm', 'category_id' => $categories['FURN']->id, 'unit' => 'Unit', 'min_stock' => 1],

            // Cleaning Supplies
            ['code' => 'CLEAN001', 'name' => 'Sabun Cuci Piring', 'category_id' => $categories['CLEAN']->id, 'unit' => 'Liter', 'min_stock' => 2],
            ['code' => 'CLEAN002', 'name' => 'Detergen', 'category_id' => $categories['CLEAN']->id, 'unit' => 'Kg', 'min_stock' => 1],
            ['code' => 'CLEAN003', 'name' => 'Sapu', 'category_id' => $categories['CLEAN']->id, 'unit' => 'Unit', 'min_stock' => 2],
            ['code' => 'CLEAN004', 'name' => 'Pel', 'category_id' => $categories['CLEAN']->id, 'unit' => 'Unit', 'min_stock' => 2],
            ['code' => 'CLEAN005', 'name' => 'Tissue Roll', 'category_id' => $categories['CLEAN']->id, 'unit' => 'Roll', 'min_stock' => 10],
            ['code' => 'CLEAN006', 'name' => 'Disinfektan', 'category_id' => $categories['CLEAN']->id, 'unit' => 'Liter', 'min_stock' => 3],

            // Computer Equipment
            ['code' => 'COMP001', 'name' => 'Mouse USB', 'category_id' => $categories['COMP']->id, 'unit' => 'Unit', 'min_stock' => 3],
            ['code' => 'COMP002', 'name' => 'Keyboard USB', 'category_id' => $categories['COMP']->id, 'unit' => 'Unit', 'min_stock' => 2],
            ['code' => 'COMP003', 'name' => 'Monitor 21 inch', 'category_id' => $categories['COMP']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'COMP004', 'name' => 'USB Cable', 'category_id' => $categories['COMP']->id, 'unit' => 'Unit', 'min_stock' => 5],
            ['code' => 'COMP005', 'name' => 'HDMI Cable', 'category_id' => $categories['COMP']->id, 'unit' => 'Unit', 'min_stock' => 3],

            // Printing Supplies
            ['code' => 'PRINT001', 'name' => 'Cartridge HP 680 Black', 'category_id' => $categories['PRINT']->id, 'unit' => 'Unit', 'min_stock' => 2],
            ['code' => 'PRINT002', 'name' => 'Cartridge HP 680 Color', 'category_id' => $categories['PRINT']->id, 'unit' => 'Unit', 'min_stock' => 2],
            ['code' => 'PRINT003', 'name' => 'Toner Canon 325', 'category_id' => $categories['PRINT']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'PRINT004', 'name' => 'Photo Paper A4', 'category_id' => $categories['PRINT']->id, 'unit' => 'Pack', 'min_stock' => 2],

            // Safety Equipment
            ['code' => 'SAFETY001', 'name' => 'Masker N95', 'category_id' => $categories['SAFETY']->id, 'unit' => 'Box', 'min_stock' => 3],
            ['code' => 'SAFETY002', 'name' => 'Hand Sanitizer', 'category_id' => $categories['SAFETY']->id, 'unit' => 'Liter', 'min_stock' => 2],
            ['code' => 'SAFETY003', 'name' => 'Sarung Tangan', 'category_id' => $categories['SAFETY']->id, 'unit' => 'Box', 'min_stock' => 2],
            ['code' => 'SAFETY004', 'name' => 'Fire Extinguisher 3kg', 'category_id' => $categories['SAFETY']->id, 'unit' => 'Unit', 'min_stock' => 1],

            // Maintenance
            ['code' => 'MAINT001', 'name' => 'Obeng Set', 'category_id' => $categories['MAINT']->id, 'unit' => 'Set', 'min_stock' => 1],
            ['code' => 'MAINT002', 'name' => 'Tang', 'category_id' => $categories['MAINT']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'MAINT003', 'name' => 'WD-40', 'category_id' => $categories['MAINT']->id, 'unit' => 'Unit', 'min_stock' => 1],
            ['code' => 'MAINT004', 'name' => 'Isolasi Listrik', 'category_id' => $categories['MAINT']->id, 'unit' => 'Roll', 'min_stock' => 3],
            ['code' => 'MAINT005', 'name' => 'Multimeter', 'category_id' => $categories['MAINT']->id, 'unit' => 'Unit', 'min_stock' => 1],
        ];

        foreach ($itemTypes as $itemType) {
            ItemType::create(array_merge($itemType, ['is_active' => true]));
        }
    }
}