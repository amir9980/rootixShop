<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail')->default('default.png');
            $table->unsignedFloat('price');
            $table->unsignedFloat('off_price')->nullable();
            $table->string('shop')->default('rootixShop');
            $table->float('rate')->default(0);
            $table->unsignedInteger('rate_count')->default(0);
            $table->text('details')->nullable();
            $table->string('status',10)->default('Inactive')->comment('Active or Inactive or Deleted');
            $table->string('delete_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
