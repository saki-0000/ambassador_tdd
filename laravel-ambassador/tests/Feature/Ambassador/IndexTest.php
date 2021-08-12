<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_アンバサダーが全て取得できること。()
    {
        $users = User::factory()->count(5)->ambassador()->create();
        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->getJson('/api/admin/ambassadors');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(5)
                    ->first(
                        fn ($json) =>
                        $json->where('first_name', $users->first()->first_name)
                            ->where('last_name', $users->first()->last_name)
                            ->where('email', $users->first()->email)
                            ->where('is_admin', $users->first()->is_admin)
                            ->missing('password')
                            ->etc()
                    )
            );
    }
}
