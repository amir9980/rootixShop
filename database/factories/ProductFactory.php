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
            'title'=>$this->faker->text(10),
            'description'=>$this->faker->sentence(20),
            'price'=>$this->faker->numberBetween(1000,100000),
            'old_price'=>$this->faker->numberBetween(1000,100000),
            'img_src'=>'default.png',
            'status'=>$this->faker->numberBetween(1,3),
        ];
    }
}
