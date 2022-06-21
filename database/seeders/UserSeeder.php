<?php

namespace Database\Seeders;

use App\Models\user;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        user::factory()->count(1)->create();
    }
}
