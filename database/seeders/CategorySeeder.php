<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->has(product::factory()->count(5))->count(10)->create();
    }
}
