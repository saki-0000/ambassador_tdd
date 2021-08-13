<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_プロダクトを作成できること。()
    {
        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->postJson('/api/admin/products', [
            'title' => 'a',
            'description' => 'a',
            'image' => 'a',
            'price' => '10.01',
        ]);
        $response->assertStatus(201);
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
