<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class userTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_認証済みadminユーザーの情報が返ってくる()
    {
        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->getJson('/api/admin/user');

        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('first_name', $user->first_name)
                    ->where('last_name', $user->last_name)
                    ->where('email', $user->email)
                    ->where('is_admin', 1)
                    ->missing('password')
                    ->etc()
            );
    }
    public function test_認証済みambassadorユーザーの情報が返ってくる()
    {
        $user = User::factory()->ambassador()->create();
        Sanctum::actingAs(
            $user,
            ['ambassador']
        );

        $response = $this->getJson('/api/ambassador/user');

        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('is_admin', 0)
                    ->etc()
            );
    }
}
