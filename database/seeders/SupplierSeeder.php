<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT Tech Indo',
                'email' => 'contact@techindo.com',
                'phone' => '021-5555678',
                'address' => 'Jl. Teknologi No. 1, Jakarta',
                'company' => 'PT Tech Indo',
                'status' => 'active',
            ],
            [
                'name' => 'CV Fashion Jaya',
                'email' => 'sales@fashionjaya.com',
                'phone' => '081234567890',
                'address' => 'Jl. Mode Raya No. 10, Bandung',
                'company' => 'CV Fashion Jaya',
                'status' => 'active',
            ],
            [
                'name' => 'UD Makmur Pangan',
                'email' => 'info@makmurpangan.com',
                'phone' => '081987654321',
                'address' => 'Jl. Pangan Sehat No. 5, Surabaya',
                'company' => 'UD Makmur Pangan',
                'status' => 'active',
            ],
            [
                'name' => 'PT Mebel Sejahtera',
                'email' => 'support@mebelsejahtera.com',
                'phone' => '024-1234567',
                'address' => 'Jl. Kayu Jati No. 88, Jepara',
                'company' => 'PT Mebel Sejahtera',
                'status' => 'active',
            ],
            [
                'name' => 'Toko Alat Tulis Budi',
                'email' => 'budi@stationery.com',
                'phone' => '085678901234',
                'address' => 'Jl. Pendidikan No. 12, Yogyakarta',
                'company' => 'Toko Budi',
                'status' => 'active',
            ],
            [
                'name' => 'Global Imports Ltd',
                'email' => 'sales@globalimports.com',
                'phone' => '+62-21-99887766',
                'address' => 'Kawasan Industri Pulogadung, Jakarta',
                'company' => 'Global Imports Ltd',
                'status' => 'inactive',
            ],
            [
                'name' => 'Local Farmers Co-op',
                'email' => 'farmers@localcoop.org',
                'phone' => '081122334455',
                'address' => 'Desa Subur Makmur, Jawa Tengah',
                'company' => 'Local Farmers Co-op',
                'status' => 'active',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
