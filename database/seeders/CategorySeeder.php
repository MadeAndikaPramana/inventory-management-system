<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => 'ATK', 'name' => 'Alat Tulis Kantor'],
            ['code' => 'ELEC', 'name' => 'Electronics'],
            ['code' => 'FURN', 'name' => 'Office Furniture'],
            ['code' => 'CLEAN', 'name' => 'Cleaning Supplies'],
            ['code' => 'COMP', 'name' => 'Computer Equipment'],
            ['code' => 'PRINT', 'name' => 'Printing Supplies'],
            ['code' => 'SAFETY', 'name' => 'Safety Equipment'],
            ['code' => 'MAINT', 'name' => 'Maintenance'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}