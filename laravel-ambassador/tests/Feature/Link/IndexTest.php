<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use App\Models\Product;
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
    public function test_あるユーザーに紐づくlinkを全て取得できること。()
    {
        $user = User::factory()->admin()
            ->hasLinks(3)
            ->create(['id' => 1000]);

        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->getJson('/api/admin/users/1000/links');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(3)
                    ->first(
                        fn ($json) =>
                        $json->where('code', $user->links()->get()->first()->code)
                            ->where('user_id', $user->links()->get()->first()->user_id)
                            ->etc()
                    )
            );
    }
}
