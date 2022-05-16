<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('User who ordered this factor.');
            $table->boolean('is_paid')->default(true)->comment('Checks if this order has paid or not.');
            $table->integer('total_price')->comment('This order total price in Tomans.');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('factor_masters');
    }
}
