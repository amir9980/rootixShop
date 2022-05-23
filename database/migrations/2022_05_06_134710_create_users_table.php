<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->boolean('is_admin')->default(false);
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
//            $table->float('wallet')->default(0);    //should test for DB::beginTransaction()
            $table->float('wallet',15,3)->default(0);
            $table->string('profile_pic')->default('defaultUser.png');
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
        Schema::dropIfExists('users');
    }
}
