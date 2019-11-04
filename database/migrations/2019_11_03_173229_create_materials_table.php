<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 32);
            $table->string('sub_title', 64);
            $table->enum('type', ['coupon', 'virtual', 'material'])->default('virtual');
            $table->tinyInteger('limit_draw')->default(1);
            $table->tinyInteger('cost')->default(0);
            $table->tinyInteger('num')->default(0);
            $table->json('imgs')->nullable();
            $table->json('ext_info')->nullable();
            $table->text('bz')->nullable();
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
        Schema::dropIfExists('materials');
    }
}
