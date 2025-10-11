<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Toko Suka Maju', 'email' => 'sukamaju@umkm.test', 'phone' => '081234567890', 'address' => 'Jl. Mawar No. 1, Yogyakarta'],
            ['name' => 'Kopi Pagi', 'email' => 'kopipagi@umkm.test', 'phone' => '081298765432', 'address' => 'Jl. Melati No. 3, Sleman'],
            ['name' => 'Batik Ayu', 'email' => 'batikayu@umkm.test', 'phone' => '081212345678', 'address' => 'Jl. Kenanga No. 7, Bantul']
        ];

        foreach ($rows as $r) { Customer::updateOrCreate(['email' => $r['email']], $r); }
    }
}
