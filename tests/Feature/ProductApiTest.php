<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    public function test_crud_products(): void
    {
        $user = User::factory()->create([
            'email' => 'p@p.com',
            'password' => Hash::make('secret123')
        ]);
        $login = $this->postJson('/api/login', ['email' => 'p@p.com', 'password' => 'secret123'])->json('data');
        $token = $login['access_token'];
        $headers = ['Authorization' => 'Bearer '.$token];

        $create = $this->postJson('/api/products', [
            'name' => 'Prod', 'sku' => 'SKU-1', 'price' => 10000, 'stock' => 5
        ], $headers)->assertStatus(201)->json('data');

        $id = $create['id'];
        $this->getJson('/api/products/'.$id, $headers)->assertOk();
        $this->putJson('/api/products/'.$id, ['name' => 'Prod X', 'sku' => 'SKU-1', 'price' => 12000, 'stock' => 10], $headers)->assertOk();
        $this->deleteJson('/api/products/'.$id, [], $headers)->assertOk();
    }
}
