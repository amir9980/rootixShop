<?php

namespace Database\Seeders;

use App\Models\DiscountToken;
use Illuminate\Database\Seeder;

class DiscountTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiscountToken::factory()->count(50)->create();
    }
}
