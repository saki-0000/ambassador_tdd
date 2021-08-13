<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_プロダクトを削除できること。()
    {
        $product = Product::factory()->create(['id' => 1000]);

        $user = User::factory()->admin()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->deleteJson('/api/admin/products/1000');
        $response->assertOk();
        $this->assertEmpty(Product::find(1000));
    }
}
