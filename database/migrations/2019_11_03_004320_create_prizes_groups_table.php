<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizesGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 32);
            $table->string('sub_title', 64)->default('');
            $table->datetime('begin');
            $table->datetime('end');
            $table->enum('limit_user', ['0', '1'])->default('0');
            $table->longText('seled_users');
            $table->enum('type', ['lottery'])->default('lottery');
            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('prizes_groups');
    }
}
