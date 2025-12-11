<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'code' => 'ELEC-001',
                'description' => 'Electronic devices and accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing',
                'code' => 'CLOTH-001',
                'description' => 'Men and women clothing',
                'is_active' => true,
            ],
            [
                'name' => 'Food & Beverage',
                'code' => 'FNB-001',
                'description' => 'Snacks, drinks, and ingredients',
                'is_active' => true,
            ],
            [
                'name' => 'Furniture',
                'code' => 'FURN-001',
                'description' => 'Home and office furniture',
                'is_active' => true,
            ],
            [
                'name' => 'Stationery',
                'code' => 'STAT-001',
                'description' => 'Office and school supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Beauty & Health',
                'code' => 'BEAUTY-001',
                'description' => 'Cosmetics and health products',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'code' => 'AUTO-001',
                'description' => 'Car and motorcycle parts',
                'is_active' => true,
            ],
            [
                'name' => 'Toys & Hobbies',
                'code' => 'TOYS-001',
                'description' => 'Toys for kids and hobby items',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
