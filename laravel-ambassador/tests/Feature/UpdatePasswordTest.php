<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * パスワードはログインしてみないと分からないので結合にて
     * @return void
     */
    public function test_パスワード更新()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $response = $this->postJson('/api/admin/users/password', [
            'password' => 'a',
            'password_confirm' => 'a',
        ]);
        $response->assertOk();

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('first_name', $user->first_name)
                    ->where('last_name', $user->last_name)
                    ->where('email', $user->email)
                    ->missing('password')
                    ->etc()
            );
    }
}
