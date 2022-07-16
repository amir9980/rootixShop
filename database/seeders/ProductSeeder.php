<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\FileUpload;
use App\Models\product;
use Database\Factories\CommentFactory;
use Database\Factories\UploadFileFactory;
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
        product::factory()->has(Comment::factory()->count(5))->count(50)->create();
    }
}
