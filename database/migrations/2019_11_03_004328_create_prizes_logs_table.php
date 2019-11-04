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
            $table->bigInteger('prizes_group_id')->default(0);
            $table->bigInteger('prize_id')->default(0);
            $table->bigInteger('material_id')->default(0);
            $table->string('material_code', 32)->default('');
            $table->enum('source', ['', 'exchange', 'lottery'])->default();
            $table->bigInteger('user_id');
            $table->json('leaving_capital')->nullable();
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
