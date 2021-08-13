<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\OrderItem;
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
        // 本当はもっと具体的なデータを作成してテストしたほうがいい？
        $orders = Order::factory()->count(5)->hasOrderItems(3)->create();
        $totalRevenue = $orders->first()->orderItems->sum(fn (OrderItem $item) => $item->adminRevenue);
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
                    ->first(
                        fn ($json) =>
                        $json->where('id', $orders->first()->id)
                            ->where('name', $orders->first()->name)
                            ->where('email', $orders->first()->email)
                            ->where('total', $totalRevenue)
                            ->where('order_items', $orders->first()->orderItems)
                            ->etc()
                    )
            );
    }
}
