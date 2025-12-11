<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SupplierApiTest extends TestCase
{
    public function test_crud_suppliers(): void
    {
        $user = User::factory()->create([
            'email' => 'sup_test_' . uniqid() . '@example.com',
            'password' => Hash::make('password')
        ]);
        $login = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password'])->json('data');
        $token = $login['access_token'];
        $headers = ['Authorization' => 'Bearer '.$token];

        // Create
        $create = $this->postJson('/api/suppliers', [
            'name' => 'Test Supplier',
            'email' => 'test_' . uniqid() . '@supplier.com',
            'phone' => '08123456789',
            'company' => 'Test Company',
            'status' => 'active'
        ], $headers)->assertStatus(201)->json('data');

        $id = $create['id'];

        // Read
        $this->getJson('/api/suppliers/'.$id, $headers)->assertOk();

        // Update
        $this->putJson('/api/suppliers/'.$id, [
            'name' => 'Test Supplier Updated',
            'email' => $create['email'],
            'phone' => '08987654321',
            'company' => 'Test Company Updated',
            'status' => 'inactive'
        ], $headers)->assertOk();

        // Delete
        $this->deleteJson('/api/suppliers/'.$id, [], $headers)->assertOk();
    }
}
