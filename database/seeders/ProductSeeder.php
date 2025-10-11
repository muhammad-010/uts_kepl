<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Biji Kopi Arabika 1kg', 'sku' => 'SKU-ARAB-1KG', 'price' => 180000, 'stock' => 25, 'description' => 'Biji kopi arabika grade A.'],
            ['name' => 'Kain Batik Tulis', 'sku' => 'SKU-BATIK-TLS', 'price' => 350000, 'stock' => 12, 'description' => 'Kain batik tulis motif parang.'],
            ['name' => 'Keripik Singkong 200g', 'sku' => 'SKU-KRS-200', 'price' => 15000, 'stock' => 200, 'description' => 'Keripik singkong gurih renyah.']
        ];

        foreach ($rows as $r) { Product::updateOrCreate(['sku' => $r['sku']], $r); }
    }
}
