<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Link::factory(10)->create();
        \App\Models\Product::factory(10)->create();
        \App\Models\Order::factory(10)->create();
        \App\Models\OrderItem::factory(10)->create();
    }
}
