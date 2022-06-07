<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscountTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token'=>Str::random(10),
            'access'=>'public',
            'usage_count'=>1,
            'percentage'=>random_int(5,50),
            'start_date'=>now(),
            'expire_date'=>now()->addDays(1),
        ];
    }
}
