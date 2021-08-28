<?php

namespace Tests\Feature\Stats;

use App\Models\Link;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\StatsService;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Mockery\MockInterface;
use Tests\TestCase;

class RankingsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_呼び出し確認()
    {
        $user = User::factory()
            ->ambassador()
            ->create(
                ['id' => 1, 'first_name' => 'matu', 'last_name' => 'tok']
            );
        User::factory()->ambassador()->create();
        Link::factory(2)
            ->create(new Sequence(
                ['user_id' => 1, 'code' => 'code1'],
                ['user_id' => 1, 'code' => 'code2'],
            ));
        Order::factory(3)->create(new Sequence(
            ['id' => 1, 'user_id' => 1, 'code' => 'code1'],
            ['id' => 2, 'user_id' => 1, 'code' => 'code2'],
            ['id' => 3, 'user_id' => 1, 'code' => 'code3'],
        ));
        Product::factory(3)->create(new Sequence(
            ['id' => 1, 'price' => 100],
            ['id' => 2, 'price' => 200],
            ['id' => 3, 'price' => 300],
        ));
        OrderItem::factory(3)->create(new Sequence(
            ['order_id' => 1, 'product_id' => 1],
            ['order_id' => 2, 'product_id' => 2],
            ['order_id' => 3, 'product_id' => 3],
        ));

        Sanctum::actingAs(
            $user,
            ['ambassador']
        );

        $response = $this->getJson('/api/ambassador/rankings');
        $response->assertOk();
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(2)
                    ->first(
                        fn ($json) =>
                        $json->where('name', 'matu tok')
                            ->where('revenue', 60)
                    )
            );
    }
}
