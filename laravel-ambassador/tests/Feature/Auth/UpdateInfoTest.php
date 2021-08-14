<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_アドミン情報更新()
    {
        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->postJson('/api/admin/users/info', [
            'first_name' => 'a',
            'last_name' => 'a',
            'email' => 'test@test.com',
        ]);
        $response->assertOk();

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('first_name', 'a')
                    ->where('last_name', 'a')
                    ->where('email', 'test@test.com')
                    ->missing('password')
                    ->etc()
            );
    }
    public function test_アンバサダー情報更新()
    {
        $user = User::factory()->ambassador()->create();
        Sanctum::actingAs(
            $user,
            ['ambassador']
        );

        $response = $this->postJson('/api/ambassador/users/info', [
            'first_name' => 'a',
            'last_name' => 'a',
            'email' => 'test@test.com',
        ]);
        $response->assertOk();

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('first_name', 'a')
                    ->where('last_name', 'a')
                    ->where('email', 'test@test.com')
                    ->missing('password')
                    ->etc()
            );
    }
}
