<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    public function test_登録したユーザーが返却されること()
    {
        // $user = User::factory()->make();
        $response = $this->postJson('/api/admin/register', [
            'first_name' => 'a',
            'last_name' => 'a',
            'email' => 'test@test.com',
            'password' => 'a',
            'password_confirm' => 'a',
        ]);
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->where('first_name', 'a')
                    ->where('last_name', 'a')
                    ->where('email', 'test@test.com')
                    ->where('is_admin', 1)
                    ->missing('password')
                    ->etc()
            );
        $response->assertStatus(201);
    }
    /**
     * TODO：フォームリクエストクラスの詳細なテストは単体で実行する予定
     *
     */
    public function test_バリデーションエラーが出ること()
    {
        $response = $this->postJson('/api/admin/register', [
            'first_name' => null,
            'last_name' => null,
            'email' => 'a',
            'password' => null,
            'password_confirm' => 'b',
        ]);
        $response
            ->assertJsonValidationErrors([
                "first_name" => "The first name field is required.",
                "last_name" => "The last name field is required.",
                "email" => "The email must be a valid email address.",
                "password" => "The password field is required.",
                "password_confirm" => "The password confirm and password must match."
            ]);
        $response->assertStatus(422);
    }
}
