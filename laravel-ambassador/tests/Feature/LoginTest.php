<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_ログイン()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertCookie('jwt');

        // TODO：Bearerトークンがセットされるかどうかのテストの方法がわからない
        // $response->assertHeader('Authorization');
        $response->assertOk();
    }
    /**
     *
     * @return void
     */
    public function test_ログインできない()
    {
        $user = User::factory()->make();

        $response = $this->postJson('/api/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertCookieMissing('jwt');
        $response->assertStatus(401);
        $this->assertGuest();
    }
}
