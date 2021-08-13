<?php

namespace Tests\Feature\Order;

use App\Models\Order;
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
    public function test_オーダーを全て取得できること。()
    {
        Order::factory()->count(5)->hasOrderItems(3)->create();
        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->getJson('/api/admin/orders');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(5)
                // ->first(
                //     fn ($json) =>
                //     $json->where('title', $products->first()->title)
                //         ->where('description', $products->first()->description)
                //         ->where('image', $products->first()->image)
                //         ->where('price', $products->first()->price)
                //         ->etc()
                // )
            );
    }
}
