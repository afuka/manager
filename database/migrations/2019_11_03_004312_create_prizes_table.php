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
            $table->bigInteger('prizes_group_id');
            $table->bigInteger('product_id');
            $table->string('name', 64);
            $table->string('bz', 128);
            $table->tinyInteger('level')->default(0);
            $table->enum('prize_type', ['empty', 'virtual', 'material'])->default('empty');
            $table->integer('num')->default(0);
            $table->integer('probability')->default(0);
            $table->enum('user_limit_type', ['no', 'per_day', 'only'])->default('no');
            $table->enum('limit_user', ['0', '1'])->default('0');
            $table->longText('seled_users')->nullable();
            $table->json('date_config')->nullable();
            $table->json('imgs')->nullable();
            $table->text('rule_bz')->nullable();
            $table->enum('is_default', ['0', '1'])->default('0');
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();

            $table->index('prizes_group_id');	
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
