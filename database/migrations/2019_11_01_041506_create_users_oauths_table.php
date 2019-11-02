<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersOauthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_oauths', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->bigInteger('user_id')->unique();
            $table->string('oauth', 16);
            $table->string('appid', 32);
            $table->string('openid', 64);
            $table->json('ext_info')->nullable();
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
        Schema::dropIfExists('users_oauths');
    }
}
