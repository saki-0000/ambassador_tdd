<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AdminITest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_ログイン()
    {
        $user = User::factory()->make();

        $response = $this->postJson('/api/admin/register', $user->only([
            'first_name',
            'last_name',
            'email',
            'password',
        ]) + ['password_confirm' => $user->password]);
        $response->assertStatus(201);

        $response = $this->postJson('/api/admin/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);
        $response->assertOk();

        $response = $this->getJson('/api/admin/user');
        $response->assertOk();

        $response = $this->getJson('/api/admin/logout');
        $response->assertOk();
    }
}
