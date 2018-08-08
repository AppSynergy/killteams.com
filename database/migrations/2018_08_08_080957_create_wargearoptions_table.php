<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWargearoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wargearoptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('miniature_id');
            $table->string('who');
            $table->string('may');
            $table->string('replace');
            $table->string('method');
            $table->string('options');
            $table->foreign('miniature_id')->references('id')->on('miniatures');
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
        Schema::dropIfExists('wargearoptions');
    }
}
