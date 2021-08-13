<?php

namespace Database\Factories;

use App\Models\LinkProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LinkProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'link_id' => $this->faker->text(),
            'product_id' => $this->faker->text(),
        ];
    }
}
