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
    public function test_アドミンログイン()
    {
        $user = User::factory()->admin()->create();

        $response = $this->postJson('/api/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertOk();

        $userModel = User::firstWhere('email', $user->email);
        $this->assertTrue($userModel->tokens->first()->abilities[0] === 'admin');

        $response->assertCookie('jwt');

        // TODO：Bearerトークンがセットされるかどうかのテストの方法がわからない
        // $response->assertHeader('Authorization');
    }
    public function test_アンバサダーログイン()
    {
        $user = User::factory()->ambassador()->create();

        $response = $this->postJson('/api/ambassador/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertOk();

        $userModel = User::firstWhere('email', $user->email);
        $this->assertTrue($userModel->tokens->first()->abilities[0] === 'ambassador');

        $response->assertCookie('jwt');
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
