<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('prize_group_id');
            $table->bigInteger('prize_id');
            $table->bigInteger('user_id');
            $table->json('leaving_capital');
            $table->string('ip', 16);
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
        Schema::dropIfExists('prizes_logs');
    }
}
