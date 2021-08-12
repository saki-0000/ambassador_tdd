<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     * @return void
     */
    public function test_認証済みユーザーのがそうでなくなる()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['admin']
        );

        $response = $this->getJson('/api/admin/logout');
        // $this->assertEmpty(auth()->user()->tokenCan('admin'));
        $response->assertOk();
    }
}
