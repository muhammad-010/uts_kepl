<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    public function test_crud_customers(): void
    {
        $user = User::factory()->create([
            'email' => 't@t.com',
            'password' => Hash::make('secret123')
        ]);
        $login = $this->postJson('/api/login', ['email' => 't@t.com', 'password' => 'secret123'])->json('data');
        $token = $login['access_token'];

        $headers = ['Authorization' => 'Bearer '.$token];
        $create = $this->postJson('/api/customers', [
            'name' => 'Foo', 'email' => 'foo@bar.com', 'phone' => '0800', 'address' => 'Addr'
        ], $headers)->assertStatus(201)->json('data');

        $id = $create['id'];
        $this->getJson('/api/customers/'.$id, $headers)->assertOk();
        $this->putJson('/api/customers/'.$id, ['name' => 'Foo2', 'email' => 'foo@bar.com', 'phone' => '0800'], $headers)->assertOk();
        $this->deleteJson('/api/customers/'.$id, [], $headers)->assertOk();
    }
}
