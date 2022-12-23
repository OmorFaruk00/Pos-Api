<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' =>\App\Models\Product::all()->random(),
            'available_quantity'=>$this->faker->numberBetween(5,10),
        ];
    }
}
