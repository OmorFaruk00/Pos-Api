<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name'=>$this->faker->unique()->sentence(1),
            'product_code'=>$this->faker->unique()->numberBetween(1,50),
            'category' =>\App\Models\Category::all()->random(),
            'brand' =>\App\Models\Brand::all()->random(),
            'unit' =>\App\Models\Unit::all()->random(),
            'purchase_price'=>$this->faker->numberBetween(100,200),
            'sales_price'=>$this->faker->numberBetween(150,400),
            'opening_qty'=>$this->faker->numberBetween(5,10),
            'alert_qty'=>$this->faker->numberBetween(5,10)
        ];
    }
}
