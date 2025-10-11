<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_can_login_and_get_token(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('secret123')
        ]);

        $res = $this->postJson('/api/login', [
            'email' => 'test@example.com', 'password' => 'secret123'
        ]);

        $res->assertStatus(200)->assertJsonPath('status', 'success');
        $this->assertArrayHasKey('access_token', $res->json('data'));
    }
}