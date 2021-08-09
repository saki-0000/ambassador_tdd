<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_認証済みユーザーのがそうでなくなる()
    {
        $user = User::factory()->create();
        // Sanctum::actingAs(
        //     $user,
        //     ['*']
        // );
        $response = $this->postJson('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertCookie('jwt');

        $response = $this->getJson('/admin/logout');
        $response->assertCookieMissing('jwt');
        $response->assertOk();
    }
}
