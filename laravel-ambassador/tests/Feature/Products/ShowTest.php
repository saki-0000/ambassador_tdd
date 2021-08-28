<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_プロダクトの詳細が取得できること。()
    {
        $product = Product::factory()->create(['id' => 1000]);

        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->getJson('/api/admin/products/1000');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('title', $product->title)
                    ->where('description', $product->description)
                    ->where('image', $product->image)
                    // ->where('price', $product->price)
                    ->etc()
            );
    }
}
