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
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('discount_token_id')->nullable();
            $table->foreign('discount_token_id')->references('id')->on('discount_tokens');
            $table->integer('discount_event_id')->nullable();
            $table->foreign('discount_event_id')->references('id')->on('discount_events');
            $table->boolean('is_paid')->default(false)->comment('Checks if this order has paid or not.');
            $table->unsignedBigInteger('total_price')->comment('This order total price in Tomans.');
            $table->string('payment_method',255)->comment('Cash, Saderat, AsanPardakht, ZarinPal.');
            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->string('tracking_code',20);
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
