<?php

namespace Database\Seeders;

use App\Models\DiscountEvent;
use Illuminate\Database\Seeder;

class DiscountEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiscountEvent::factory()->count(1)->create();
    }
}
