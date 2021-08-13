<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_プロダクトを作成できること。()
    {
        $product = Product::factory()->create(['id' => 1000]);

        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->putJson('/api/admin/products/1000', [
            'title' => 'a',
            'description' => 'a',
            'image' => 'a',
            'price' => '10.01',
        ]);
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('title', 'a')
                    ->where('description', 'a')
                    ->where('image', 'a')
                    ->where('price', 10.01)
                    ->etc()
            );
    }
}
