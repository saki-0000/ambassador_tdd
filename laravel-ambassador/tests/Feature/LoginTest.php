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

        $response = $this->postJson('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('first_name', $user->first_name)
                    ->where('last_name', $user->last_name)
                    ->where('email', $user->email)
                    ->where('is_admin', $user->is_admin)
                    ->missing('password')
                    ->etc()
            );

        $this->assertAuthenticated();
        $response->assertOk();
    }
}
