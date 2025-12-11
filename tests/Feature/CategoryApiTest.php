<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    public function test_crud_categories(): void
    {
        $user = User::factory()->create([
            'email' => 'cat_test_' . uniqid() . '@example.com',
            'password' => Hash::make('password')
        ]);
        $login = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password'])->json('data');
        $token = $login['access_token'];
        $headers = ['Authorization' => 'Bearer '.$token];

        // Create
        $create = $this->postJson('/api/categories', [
            'name' => 'Test Category ' . uniqid(),
            'code' => 'TC-' . rand(1000, 9999),
            'description' => 'Description test',
            'is_active' => true
        ], $headers)->assertStatus(201)->json('data');

        $id = $create['id'];

        // Read
        $this->getJson('/api/categories/'.$id, $headers)->assertOk();

        // Update
        $this->putJson('/api/categories/'.$id, [
            'name' => 'Test Category Updated ' . uniqid(),
            'code' => $create['code'],
            'description' => 'Updated description',
            'is_active' => false
        ], $headers)->assertOk();

        // Delete
        $this->deleteJson('/api/categories/'.$id, [], $headers)->assertOk();
    }
}
