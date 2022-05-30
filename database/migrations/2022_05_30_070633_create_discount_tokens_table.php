<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('access',10)->comment("Public or Private.");
            $table->string('token',255);
            $table->integer('user_id')->nullable()->comment('this is null if access is public');
            $table->tinyInteger('percentage');
            $table->dateTime('start_date');
            $table->dateTime('expire_date');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_tokens');
    }
}
