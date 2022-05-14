<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,50) as $item){
            DB::table('products')->insert([
                'title'=>$item.'عنوان',
                'description' => $item.'توضیحات',
                'price'=>$item*1000,
                'old_price'=>$item*1000+1000,
                'img_src'=>'default.png',
                'status'=>1,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
