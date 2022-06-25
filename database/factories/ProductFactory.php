<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'status'=>$this->faker->numberBetween(1,3),
            'details'=>[
                'colors'=>[Str::random(5),Str::random(5),Str::random(5)],
                'sizes'=>[1,3,4]
            ]
        ];
    }
}
