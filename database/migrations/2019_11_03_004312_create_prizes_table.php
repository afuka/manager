<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('prize_group_id');
            $table->bigInteger('product_id');
            $table->string('name', 64);
            $table->string('bz', 128);
            $table->tinyInteger('level');
            $table->enum('prize_type', ['empty', 'virtual', 'material'])->default('empty');
            $table->integer('num');
            $table->integer('probability');
            $table->enum('user_limit_type', ['no', 'per_day', 'only'])->default('no');
            $table->json('date_config');
            $table->json('ext_info');
            $table->text('rule_bz');
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();

            $table->index('prize_group_id');	
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
