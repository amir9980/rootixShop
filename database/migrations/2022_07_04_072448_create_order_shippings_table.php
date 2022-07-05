<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('factor_id');
            $table->foreign('factor_id')->references('id')->on('factor_masters');
            $table->string('type',10)->comment('ordered, checked, sent, delivered')->default('ordered');
            $table->string('tracking_code',20);
            $table->text('ordered_description');
            $table->text('checked_description')->nullable();
            $table->text('sent_description')->nullable();
            $table->text('delivered_description')->nullable();
            $table->text('extra_field')->nullable();
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
        Schema::dropIfExists('order_shippings');
    }
}
