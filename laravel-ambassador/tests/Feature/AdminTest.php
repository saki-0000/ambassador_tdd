<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 登録時に返却されるユーザーが正しいか
     *
     * @return void
     */
    public function test_レジスター()
    {
        $data = [
            'first_name' => 'a',
            'last_name' => 'a',
            'email' => 'test@test.com',
        ];
        $response = $this->post('/admin/regester', $data + [
            'password' => 'a',
            'password_confirm' => 'a',
        ]);
        $response->assertJsonFragment($data + ['is_admin' => 1]);
        $response->assertStatus(201);
    }
}
