<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_プロダクトを全て取得できること。()
    {
        $products = Product::factory()->count(5)->create();
        $user = User::factory()->ambassador()->create();
        Sanctum::actingAs(
            $user,
            ['ambassador']
        );

        $response = $this->getJson('/api/ambassador/products/frontend');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(5)
                    ->first(
                        fn ($json) =>
                        $json->where('title', $products->first()->title)
                            ->where('description', $products->first()->description)
                            ->where('image', $products->first()->image)
                            ->where('price', $products->first()->price)
                            ->etc()
                    )
            );
    }
}
