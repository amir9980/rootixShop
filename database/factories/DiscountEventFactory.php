<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscountEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>Str::random(5),
            'description'=>Str::random(20),
            'percentage'=>10,
            'start_date'=>now(),
            'expire_date'=>now()->addDays(1),
        ];
    }
}
