<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_レジスター()
    {
        $response = $this->post('/admin/regester');
        $response->assertJson(['test']);
        $response->assertStatus(200);
    }
}
