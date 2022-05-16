<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_details', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->comment('Ordered product.');
            $table->integer('count')->comment('Number of order.');
            $table->integer('master_id')->comment('Master factor of this product.');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('master_id')->references('id')->on('baskets_master');
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
        Schema::dropIfExists('factor_details_');
    }
}
