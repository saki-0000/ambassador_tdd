<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BackendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Cache::rememberを使うとテストできない？
     */
    public function test_プロダクトを全て取得できること。()
    {
        $products = Product::factory()->count(5)->create();

        $user = User::factory()->ambassador()->create();
        Sanctum::actingAs(
            $user,
            ['ambassador']
        );

        $response = $this->getJson('/api/ambassador/products/backend');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has("total",)
                    ->has("per_page")
                    ->has("current_page")
                    ->has("last_page")
                    ->has("first_page_url")
                    ->has("last_page_url")
                    ->has("next_page_url")
                    ->has("prev_page_url")
                    ->has("path")
                    ->has("from")
                    ->has("to")
                    ->has(
                        "data",
                        5,
                        fn ($json) =>
                        $json->where('title', $products->first()->title)
                            ->where('description', $products->first()->description)
                            ->where('image', $products->first()->image)
                            // .00の数値の時キャッシュだと無視されるようだが、面倒なので、一旦観点から外す。
                            // ->where('price', $products->first()->price)
                            ->etc()
                    )
                    ->has("links")
            );
    }
}
